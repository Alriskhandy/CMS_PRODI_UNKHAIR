<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    CommentsController,
    DashboardController,
    GalleriesController,
    GeneralSettingsController,
    JadwalController,
    MediaController,
    MenuItemController,
    PageController,
    PostsCategoriesController,
    PostsController,
    ProfileController,
    ThemeController
};

Route::prefix('/cms-unkhair/cp')->middleware('auth')->group(function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Media
    Route::get('/media', [MediaController::class, 'index'])->name('media.index');
    Route::post('/upload', [MediaController::class, 'upload'])->name('file.upload');

    // Posts
    Route::get('/posts', [PostsController::class, 'index'])->name('posts.index');
    Route::get('/create-post', [PostsController::class, 'create'])->name('posts.create');
    Route::post('/posts/store', [PostsController::class, 'store'])->name('posts.store');
    Route::get('/post/{post:slug}/edit', [PostsController::class, 'edit'])->name('posts.edit');
    Route::put('/post/{post:slug}', [PostsController::class, 'update'])->name('posts.update');
    Route::post('/posts/bulk', [PostsController::class, 'bulk'])->name('posts.bulk_action');

    // Post Categories
    Route::get('/posts/categories/all', [PostsCategoriesController::class, 'index'])->name('posts.categories.index');
    Route::post('/categories', [PostsCategoriesController::class, 'store'])->name('categories.store');
    Route::get('/categories/{id}/edit', [PostsCategoriesController::class, 'edit'])->name('categories.edit');
    Route::put('/posts/categories/all/{id}', [PostsCategoriesController::class, 'update'])->name('categories.update');
    Route::delete('/categories/{id}', [PostsCategoriesController::class, 'destroy'])->name('categories.destroy');

    // Jadwal Perkuliahan
    Route::get('/jadwal', [JadwalController::class, 'index'])->name('jadwal.index');
    Route::post('/jadwal/store', [JadwalController::class, 'store'])->name('jadwal.create');
    Route::put('/jadwal/{id}', [JadwalController::class, 'update'])->name('jadwal.edit');
    Route::delete('/jadwal/{id}', [JadwalController::class, 'destroy'])->name('jadwal.destroy');

    // Theme
    Route::get('/tema', [ThemeController::class, 'index'])->name('tema.index');
    Route::get('/ganti-tema/{themeId}', [ThemeController::class, 'switchTheme'])->name('ganti.tema');

    // Pages
    Route::get('/pages', [PageController::class, 'index'])->name('pages.index');
    Route::get('/pages/create', [PageController::class, 'create'])->name('pages.create');
    Route::post('/pages', [PageController::class, 'store'])->name('pages.store');
    Route::get('/pages/{id}/edit', [PageController::class, 'edit'])->name('pages.edit');
    Route::put('/pages/{id}', [PageController::class, 'update'])->name('pages.update');
    Route::delete('/pages/{id}', [PageController::class, 'destroy'])->name('pages.destroy');

    // Menus
    Route::get('/menus', [MenuItemController::class, 'index'])->name('menus.index');
    Route::get('/menus/create', [MenuItemController::class, 'create'])->name('menus.create');
    Route::post('/menus', [MenuItemController::class, 'store'])->name('menus.store');
    Route::patch('/menus/{menu}/update', [MenuItemController::class, 'update'])->name('menus.update');
    Route::post('/menu/update-order', [MenuItemController::class, 'updateOrder'])->name('menu.updateOrder');
    Route::delete('/menu-items/{id}', [MenuItemController::class, 'destroy'])->name('menu-items.destroy');

    // Backup
    Route::get('/backup/download', [GeneralSettingsController::class, 'downloadBackup'])->name('backup.download');
    Route::get('/backup/storage', [GeneralSettingsController::class, 'downloadStorageBackup'])->name('backup.storage');

    // Settings
    Route::get('/settings', [GeneralSettingsController::class, 'index'])->name('settings.index');
    Route::post('/settings', [GeneralSettingsController::class, 'update'])->name('settings.update');

    // Galleries
    Route::get('/galleries', [GalleriesController::class, 'index'])->name('galleries.index');
    Route::get('/galleries/create', [GalleriesController::class, 'create'])->name('galleries.create');
    Route::post('/galleries', [GalleriesController::class, 'store'])->name('galleries.store');
    Route::get('/galleries/{id}', [GalleriesController::class, 'show'])->name('galleries.show');
    Route::get('/galleries/{id}/edit', [GalleriesController::class, 'edit'])->name('galleries.edit');
    Route::put('/galleries/{id}', [GalleriesController::class, 'update'])->name('galleries.update');
    Route::delete('/galleries/{id}', [GalleriesController::class, 'destroy'])->name('galleries.destroy');
    Route::delete('/gallery/image/{id}', [GalleriesController::class, 'destroyImage'])->name('galleries.image.destroy');

    // Comments
    Route::get('/comments', [CommentsController::class, 'index'])->name('comments.index');
    Route::get('/comments/{id}/edit', [CommentsController::class, 'edit'])->name('comments.edit');
    Route::put('/comments/{id}', [CommentsController::class, 'update'])->name('comments.update');
    Route::delete('/comments/{id}', [CommentsController::class, 'destroy'])->name('comments.destroy');
});
