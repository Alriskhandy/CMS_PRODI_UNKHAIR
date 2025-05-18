<?php

namespace App\Http\Controllers;

use App\Models\Categories;
use App\Models\Comments;
use App\Models\Dosen;
use App\Models\Jadwal;
use App\Models\Page;
use App\Models\Posts;
use App\Models\RPS;
use Illuminate\Http\Request;
use App\Models\Theme;

class FrontEndController extends Controller
{
    public function index()
    {
        $theme = Theme::where('active', true)->first()->path;

        // Ambil kategori "Agenda" dan "Pengumuman"
        // $agendaPosts = Posts::whereHas('category', function ($query) {
        //     $query->where('name', 'Agenda');
        // })->latest()->get();

        $beritaUtama = Posts::where('is_featured', 1)->latest()->get();

        $pengumumanPosts = Posts::whereHas('category', function ($query) {
            $query->where('name', 'Pengumuman');
        })->latest()->get();

        $posts = Posts::whereIn('status', ['published', 'approved'])->latest()->get();

        return view($theme . '.index', compact('beritaUtama', 'pengumumanPosts', 'posts'));
    }

    public function showPage($slug)
    {
        $theme = Theme::where('active', true)->first()->path;
        $data = []; // Data yang diperlukan

        // Temukan halaman berdasarkan slug
        $page = Page::where('slug', $slug)->firstOrFail();

        return view($theme . '.pages', compact('data', 'page'));
    }

    public function showPost($slug)
    {
        $theme = Theme::where('active', true)->first()->path;


        // Temukan halaman berdasarkan slug
        $page = Posts::where('slug', $slug)->firstOrFail();

        $comments = Comments::where('status', 'approved')
            ->where('post_id', $page->id)
            ->latest()
            ->get();

        // dd($page);

        return view($theme . '.detail_post', compact('comments', 'page'));
    }

    public function showCategories($slug)
    {
        $theme = Theme::where('active', true)->first()->path;
        // $data = []; // Data yang diperlukan

        // Temukan halaman berdasarkan slug
        $category = Categories::where('slug', $slug)->firstOrFail();

        $posts = Posts::where('category_id', $category->id)->latest()->paginate(8); // Batasi 10 posting per halaman

        // dd($posts);
        return view($theme . '.posts_categories', compact('category', 'posts'));
    }

    public function allPosts()
    {
        $theme = Theme::where('active', true)->first()->path;
        // $data = []; // Data yang diperlukan

        $posts = Posts::whereIn('status', ['published', 'approved'])->latest()->paginate(8);


        // dd($posts);
        return view($theme . '.posts_categories', compact('posts'));
    }

    public function showJadwal()
    {
        $theme = Theme::where('active', true)->first()->path;
        return view($theme . '.detail_jadwal', [
            'jadwal' => Jadwal::all(),
        ]);
    }

    public function showRPS()
    {
        $theme = Theme::where('active', true)->first()->path;
        return view($theme . '.detail_rps', [
            'rps' => RPS::first(),
        ]);
    }

    public function showDosen()
    {
        $theme = Theme::where('active', true)->first()->path;
        return view($theme . '.detail_dosen', [
            'dosen' => Dosen::all(),
        ]);
    }
}
