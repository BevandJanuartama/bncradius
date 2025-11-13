<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Migration: Membuat tabel "infos"
 *
 * Tabel ini digunakan untuk menyimpan catatan aktivitas sistem atau log informasi,
 * seperti siapa yang melakukan aksi, dari IP mana, dan kapan kejadian terjadi.
 *
 * File ini dijalankan melalui perintah artisan:
 *   php artisan migrate
 */
return new class extends Migration
{
    /**
     * Jalankan migrasi untuk membuat tabel infos.
     */
    public function up(): void
    {
        Schema::create('infos', function (Blueprint $table) {
            $table->id(); // Primary key otomatis

            $table->string('nama_lengkap'); // nama lengkap pengguna / pelaku aktivitas
            $table->string('telepon')->nullable(); // nomor telepon (opsional)
            $table->string('ip_address'); // alamat IP sumber aktivitas
            $table->string('info_aktifitas'); // deskripsi aktivitas (misal: login, update data)
            $table->timestamp('tanggal_kejadian'); // waktu kejadian aktivitas
            $table->string('level')->nullable(); // level aktivitas (misal: admin, user)
            $table->timestamps(); // created_at & updated_at otomatis
        });
    }

    /**
     * Batalkan migrasi (hapus tabel infos).
     */
    public function down(): void
    {
        Schema::dropIfExists('infos');
    }
};
