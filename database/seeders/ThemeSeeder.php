<?php

namespace Database\Seeders;

use App\Models\Theme;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ThemeSeeder extends Seeder
{
    /**
     * Jalankan seeder untuk mengisi data tema ke dalam database.
     *
     * Theme::create([
     *     'name' => 'Nama Tema Baru',
     *     'path' => 'themes/nama-folder',
     *     'image' => 'themes/nama-gambar.png',
     *     'active' => 0,
     * ]);
     * 
     * @return void
     */
    public function run(): void
    {
        // Tema default yang aktif
        Theme::create([
            'name' => 'Default',
            'path' => 'themes/zenblog',
            'image' => 'themes/zenblog.png',
            'active' => 1,
        ]);

        // Tema alternatif (non-aktif)
        Theme::create([
            'name' => 'simple-blog',
            'path' => 'themes/simple-blog',
            'image' => 'themes/simple-blog.png',
            'active' => 0,
        ]);
    }
}
