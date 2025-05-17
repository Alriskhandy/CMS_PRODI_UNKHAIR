<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Define Gate untuk IsAdmin
        Gate::define('IsAdmin', function (User $user) {
            return $user->role->nama_role === 'Admin'; // Ganti sesuai nama kolom role di tabel users
        });
    }
}
