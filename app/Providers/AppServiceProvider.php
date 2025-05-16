<?php

namespace App\Providers;

use App\Models\Categories;
use App\Models\Comments;
use App\Models\GeneralSettings;
use App\Models\Menu;
use App\Models\Posts;
use Carbon\Carbon;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::useBootstrap(); // Gunakan gaya Bootstrap

        // Ambil menu aktif beserta itemnya untuk dibagikan ke seluruh view
        $menus = Menu::with(['items' => function ($query) {
            $query->whereNull('parent_id')  // Only top-level items
                ->with(['children', 'page', 'post', 'category'])  // Eager load relationships
                ->orderBy('order');  // Optional: Order by 'order' column
        }])
            ->where('status', 'aktif')  // Only fetch active menus
            ->get();

        // Ambil semua kategori
        $categoriesAll = Categories::all();

        // Ambil data dari model Setting
        $site_name = GeneralSettings::where('key', 'site_name')->firstOrFail();
        // Bagikan data ke semua view
        View::share('site_name', $site_name);

        $site_logo = GeneralSettings::where('key', 'site_logo')->firstOrFail();

        // Bagikan data ke semua view
        View::share('site_logo', $site_logo);

        // Bagikan ke semua view
        View::share('categoriesAll', $categoriesAll);
        // Membagikan variabel $menus ke semua view
        View::share('menus', $menus);


        // Ambil bulan dan tahun saat ini
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;

        // Mengambil 5 post teratas berdasarkan views dalam bulan dan tahun ini
        $trendingPosts = Posts::whereMonth('created_at', $currentMonth)
            ->whereYear('created_at', $currentYear)
            ->orderBy('views', 'desc')
            ->take(5)
            ->get();
        // Membagikan data trending posts ke semua view
        View::share('trendingPosts', $trendingPosts);

        // Menghitung jumlah post yang belum dibaca (read = false)
        $unreadCommentsCount = Comments::where('read', false)->count();
        // Membagikan data trending posts ke semua view
        View::share('unreadCommentsCount', $unreadCommentsCount);

        $banner = Posts::where('is_banner', 1)
            ->where('status', 'published')
            ->latest()
            ->get();

        View::share('banner', $banner);
    }
}
