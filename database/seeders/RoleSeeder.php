<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Jalankan seeder untuk mengisi data role pengguna ke dalam database.
     */
    public function run(): void
    {
        Role::create([
            'nama_role' => 'Admin'
        ]);
        Role::create([
            'nama_role' => 'Penulis'
        ]);
    }
}
