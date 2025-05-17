<?php

namespace App\Http\Controllers;

use App\Enums\PostStatus;
use App\Models\Categories;
use App\Models\Posts;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class PostsController extends Controller
{
    public function index(Request $request)
    {
        // Mendapatkan status dari query string
        $status = $request->query('status');

        // Mendapatkan user yang sedang login
        $user = Auth::user();

        // Menghitung total posts berdasarkan role
        if ($user->role->nama_role === 'Admin') {
            $totalPosts = Posts::whereNull('deleted_at')->count();
            $totalTrashed = Posts::onlyTrashed()->count();
        } else {
            $totalPosts = Posts::whereNull('deleted_at')
                ->where('author', $user->name)
                ->count();

            $totalTrashed = Posts::onlyTrashed()
                ->where('author', $user->name)
                ->count();
        }

        // Ambil postingan berdasarkan status dan role
        if ($status === 'trashed') {
            $posts = Posts::onlyTrashed()
                ->when($user->role->nama_role !== 'Admin', function ($query) use ($user) {
                    $query->where('author', $user->name);
                })
                ->with('categories')
                ->orderBy('deleted_at', 'desc')
                ->get();
        } else {
            $posts = Posts::whereNull('deleted_at')
                ->when($user->role->nama_role !== 'Admin', function ($query) use ($user) {
                    $query->where('author', $user->name);
                })
                ->with('categories')
                ->orderBy('created_at', 'desc')
                ->get();
        }

        // Menentukan apakah ada posts yang dihapus
        $hasTrashed = $totalTrashed > 0;
        $categories = Categories::all();

        // Mengembalikan tampilan dengan data yang diperlukan
        return view('backend.posts.index', compact('posts', 'categories', 'status', 'hasTrashed', 'totalPosts', 'totalTrashed'));
    }

    public function create()
    {
        $canBeFeatured = Posts::where('is_featured', 1)->count() < 4;
        $canBeBanner = Posts::where('is_banner', 1)->count() < 3;

        return view('backend.posts.create', [
            'categories' => Categories::all(),
            'canBeFeatured' => $canBeFeatured,
            'canBeBanner' => $canBeBanner,
        ]);
    }

    public function store(Request $request)
    {
        // dd($request->input('category_id'));
        // Validasi input
        $validatedData = $this->validateRequest($request);
        // dd($validatedData['category_id']);

        // Buat dan simpan pos baru menggunakan mass assignment
        $post = Posts::create([
            'title' => $validatedData['title'],
            'slug' => Str::slug($validatedData['title']),
            'excerpt' => Str::limit(strip_tags($validatedData['content']), 150),
            'status' => $validatedData['status'],
            'content' => $validatedData['content'],
            'comments_is_active' => $validatedData['comments_is_active'],
            'is_featured' => $validatedData['is_featured'],
            'is_banner' => $validatedData['is_banner'],
            'views' => 0,
            'author' => Auth::user()->name,
            'image' => $request->input('image'),
            'category_id' => $request->input('category_id'),
        ]);

        // // Lampirkan kategori jika ada
        // if (!empty($validatedData['category'])) {
        //     $post->categories()->attach($validatedData['category']);
        // }

        // Menggunakan notifikasi notify()
        notify()->success('Postingan Berhasil di Buat!');

        return redirect()->route('posts.index');
    }

    private function validateRequest(Request $request)
    {
        //  dd($request->category_id);
        return $request->validate([
            'title' => 'required|string|max:255|unique:posts',
            'content' => 'required',
            'image' => 'required',
            'status' => 'required|in:draft,published,trashed',
            'comments_is_active' => 'required|boolean',
            'category_id' => 'required|exists:categories,id',
            'is_featured' => 'required|boolean',
            'is_banner' => 'required|boolean',
        ]);
    }

    public function show($id)
    {
        // Temukan post berdasarkan ID
        $post = Posts::findOrFail($id);

        if (Auth::user()->role->nama_role !== 'Admin' && Auth::user()->name !== $post->author) {
            return back();
        }

        return view('backend.posts.show', compact('post'));
    }

    public function bulk(Request $request)
    {
        $action = $request->input('action');
        $selectedPosts = $request->input('selected_posts', []);

        if (!$selectedPosts) {
            notify()->error('Pilih Post Terlebih Dahulu!');
            return redirect()->back();
        }

        switch ($action) {
            case 'trash':
                Posts::whereIn('id', $selectedPosts)
                    ->update(['status' => PostStatus::Trashed->value, 'deleted_at' => now()]);
                notify()->success('Posts berhasil dipindahkan ke tong sampah.');
                break;

            case 'delete':
                Posts::whereIn('id', $selectedPosts)->forceDelete();
                notify()->success('Posts berhasil dihapus permanen.');
                break;

            case 'publish':
                Posts::whereIn('id', $selectedPosts)
                    ->update(['status' => PostStatus::Published->value]);
                notify()->success('Posts berhasil diterbitkan.');
                break;

            case 'draft':
                Posts::whereIn('id', $selectedPosts)
                    ->update(['status' => PostStatus::Draft->value]);
                notify()->success('Posts berhasil diubah ke draft.');
                break;

            case 'kembalikan':
                Posts::whereIn('id', $selectedPosts)->restore();
                Posts::whereIn('id', $selectedPosts)
                    ->update(['status' => PostStatus::Published->value]);
                notify()->success('Posts berhasil dikembalikan.');
                break;

            default:
                notify()->error('Pilih Tindakan!');
                return redirect()->back();
        }

        return redirect()->route('posts.index', ['status' => $request->query('status')]);
    }

    public function edit(Posts $post)
    {
        if (Auth::user()->role->nama_role !== 'Admin' && Auth::user()->name !== $post->author) {
            return back();
        }

        $canBeFeatured = Posts::where('is_featured', 1)->count() < 4;
        $canBeBanner = Posts::where('is_banner', 1)->count() < 3;

        return view('backend.posts.edit', [
            'post' => $post,
            'categories' => Categories::all(),
            'canBeFeatured' => $canBeFeatured,
            'canBeBanner' => $canBeBanner,
        ]);
    }

    public function update(Request $request, Posts $post)
    {
        if (Auth::user()->role->nama_role !== 'Admin' && Auth::user()->name !== $post->author) {
            return back();
        }
        // Validasi untuk memastikan 'is_banner' hanya dibutuhkan jika radio button aktif
        $canBeBanner = Posts::where('is_banner', 1)->count() < 3; // Hanya bisa ada maksimal 3 banner
        $canBeFeatured = Posts::where('is_featured', 1)->count() < 4; // Hanya bisa ada maksimal 4 featured posts
        // Validasi input
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required',
            'status' => 'required|in:draft,published,trashed',
            'comments_is_active' => 'required|boolean',
            'is_featured' => [
                'nullable',
                'boolean',
                // Validasi hanya diterapkan jika jumlah featured belum mencapai batas
                $canBeFeatured ? 'required' : '',
            ],
            'is_banner' => [
                'nullable',
                'boolean',
                // Validasi hanya diterapkan jika jumlah banner belum mencapai batas
                $canBeBanner ? 'required' : '',
            ],
            // 'image' => 'required',
            'category_id' => 'required|exists:categories,id',
        ]);

        // Menghasilkan slug dari judul
        $slugs = Str::slug($request->title);

        // Memperbarui post dengan data yang baru
        $post->update([
            'title' => $request->title,
            'slug' => $slugs,
            'image' => $request->input('image'),
            'content' => $request->content,
            'status' => $request->status,
            'category_id' => $request->category_id,
            'comments_is_active' => $request->comments_is_active,
            'is_featured' => $request->has('is_featured') ? $request->is_featured : $post->is_featured, // Jika tidak ada perubahan, tetap gunakan nilai lama
            'is_banner' => $request->has('is_banner') ? $request->is_banner : $post->is_banner, // Jika tidak ada perubahan, tetap gunakan nilai lama
            // Tambahkan kategori jika diperlukan
        ]);

        // // Lampirkan kategori jika ada
        // if ($request->has('category')) {
        //     $post->categories()->sync($request->category);
        // }

        notify()->success('Post berhasil diperbarui.');
        return redirect()->route('posts.index');
    }
}
