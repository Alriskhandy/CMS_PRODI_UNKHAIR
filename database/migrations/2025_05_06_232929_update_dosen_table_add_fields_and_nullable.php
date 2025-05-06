<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('dosen', function (Blueprint $table) {
            // Hapus kolom nip lama
            $table->dropColumn('nip');
        });

        Schema::table('dosen', function (Blueprint $table) {
            // Tambah ulang kolom nip dengan tipe string (18 karakter), nullable
            $table->string('nip', 18)->nullable()->after('nama');

            // Tambah kolom nidn
            $table->string('nidn', 10)->nullable()->after('nip');
        });
    }

    public function down(): void
    {
        Schema::table('dosen', function (Blueprint $table) {
            // Hapus kolom nip dan nidn baru
            $table->dropColumn(['nip', 'nidn']);
        });

        Schema::table('dosen', function (Blueprint $table) {
            // Tambah ulang kolom nip sebagai unsignedBigInteger, NOT NULL
            $table->unsignedBigInteger('nip')->after('nama');
        });
    }
};

