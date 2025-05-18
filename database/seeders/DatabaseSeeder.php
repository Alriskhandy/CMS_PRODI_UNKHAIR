<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;


class DatabaseSeeder extends Seeder
{
    /**
     * Jalankan seeder untuk mengisi data yang diperlukan ke dalam database.
     */
    public function run(): void
    {
        $this->call([
            GeneralSettingsSeeder::class,
            ThemeSeeder::class,
            MenuSeeder::class,
            RoleSeeder::class,
            UserSeeder::class,
            GalleriesSeeder::class,
            CategoriesSeeder::class,
            // PostSeeder::class,
        ]);
    }
}
