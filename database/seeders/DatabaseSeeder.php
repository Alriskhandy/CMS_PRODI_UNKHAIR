<?php

namespace Database\Seeders;

use App\Models\Categories;
use App\Models\Role;
use App\Models\Theme;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // $this->call([
        //     CategoriesSeeder::class,
        //     PostSeeder::class, // Pastikan PostSeeder juga ditambahkan di sini
        //     MenuSeeder::class
        // ]);

        // Role::create([
        //     'nama_role' => 'Admin'
        // ]);
        // Role::create([
        //     'nama_role' => 'Penulis'
        // ]);

        // User::create([
        //     'name' => 'admin',
        //     'email' => 'admin@gmail.com',
        //     'password' => Hash::make('admin123'), // Hash the password
        //     'role_id' => 1,
        // ]);
        // Categories::create([
        //     'slug' => 'berita',
        //     'name' => 'Berita',
        // ]);
        // Categories::create([
        //     'slug' => 'news',
        //     'name' => 'News',
        // ]);

        // Theme::create([
        //     'name' => 'Retmu',
        //     'path' => 'themes/zenblog',
        //     'image' => 'themes/zenblog.png',
        //     'active' => 1,
        // ]);
        // Theme::create([
        //     'name' => 'news-master',
        //     'path' => 'themes/news-master',
        //     'image' => 'themes/news-master.png',
        //     'active' => 0,
        // ]);

        // Theme::create([
        //     'name' => 'nextpage-lite',
        //     'path' => 'themes/nextpage-lite',
        //     'image' => 'themes/nextpage-lite.png',
        //     'active' => 0,
        // ]);
        // Theme::create([
        //     'name' => 'nextpage-lite',
        //     'path' => 'themes/medicio',
        //     'image' => 'themes/medicio.png',
        //     'active' => 0,
        // ]);


        // $this->call(GalleriesSeeder::class);
        // $this->call(GeneralSettingsSeeder::class);

        // Theme::create([
        //     'name' => 'simple-blog',
        //     'path' => 'themes/simple-blog',
        //     'image' => 'themes/simple-blog.png',
        //     'active' => 0,
        // ]);
    }
}
