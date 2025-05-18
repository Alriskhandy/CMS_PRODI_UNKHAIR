<?php

namespace Database\Seeders;

use App\Models\Categories;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategoriesSeeder extends Seeder
{
    /**
     * Jalankan seeder untuk mengisi data kategori postingan ke dalam database.
     */
    public function run(): void
    {
        Categories::create([
            'name' => 'Pengumuman',
            'slug' => 'pengumuman'
        ]);

        Categories::create([
            'name' => 'Agenda',
            'slug' => 'agenda'
        ]);

        Categories::create([
            'slug' => 'berita',
            'name' => 'Berita',
        ]);

        Categories::create([
            'slug' => 'news',
            'name' => 'News',
        ]);
    }
}
