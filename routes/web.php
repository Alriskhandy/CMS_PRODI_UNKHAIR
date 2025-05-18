<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\{
    CommentsController,
    FrontEndController,
    GalleriesController,
    PageController,
    ProfileController,
    SearchController
};

// Utilities
Route::get('/seeder', fn() => Artisan::call('db:seed'));
Route::get('/migrate', fn() => Artisan::call('migrate'));
Route::get('/clear', function () {
    Artisan::call('config:clear');
    Artisan::call('cache:clear');
    return "Cache cleared successfully";
});

// Frontend Routes
Route::get('/', [FrontEndController::class, 'index']);
Route::get('/search', [SearchController::class, 'searchPosts'])->name('search');
Route::get('/search-menu', [SearchController::class, 'searchMenu'])->middleware('auth')->name('search-menu');

// Galleries
Route::get('/galleries', [GalleriesController::class, 'front'])->name('galleries.front');
Route::get('/gallery/{slug}', [GalleriesController::class, 'detail'])->name('gallery.detail');

// Daftar Dosen
Route::get('/daftar-dosen', [FrontEndController::class, 'showDosen'])->name('dosen.show');

// Jadwal
Route::get('/jadwal', [FrontEndController::class, 'showJadwal'])->name('jadwal.show');

// RPS
Route::get('/rps', [FrontEndController::class, 'showRPS'])->name('rps.show');

// Posts
Route::get('posts', [FrontEndController::class, 'allPosts'])->name('allPosts');
Route::get('posts/{slug}', [FrontEndController::class, 'showPost'])->name('posts.show');

// Categories
Route::get('categories/{slug}', [FrontEndController::class, 'showCategories'])->name('categories.show');

// Pages
Route::get('pages/{slug}', [FrontEndController::class, 'showPage'])->name('pages.show');

// Comments
Route::post('comments-post', [CommentsController::class, 'store'])->name('comments.store');

// User Profile (authenticated)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Laravel File Manager
Route::group(['prefix' => 'cms-unkhair-filemanager', 'middleware' => ['web', 'auth']], function () {
    \UniSharp\LaravelFilemanager\Lfm::routes();
});

// Auth and Backend
require __DIR__ . '/auth.php';
require __DIR__ . '/backend.php';
