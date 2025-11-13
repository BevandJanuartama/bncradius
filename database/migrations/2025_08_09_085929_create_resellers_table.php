<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Migration: Membuat tabel "resellers"
 *
 * Tabel ini digunakan untuk menyimpan data reseller, yaitu pihak yang
 * menjadi perantara penjualan produk/jasa ke pelanggan akhir.
 * Setiap reseller memiliki identitas pribadi, batas hutang, tanggal bergabung,
 * serta hak akses tertentu terhadap sistem router, server, dan profile.
 *
 * File ini dijalankan melalui perintah artisan:
 *   php artisan migrate
 */
return new class extends Migration
{
    /**
     * Jalankan migrasi untuk membuat tabel resellers.
     *
     * Method `up()` berisi definisi struktur kolom dari tabel `resellers`.
     * Saat perintah `php artisan migrate` dijalankan,
     * instruksi di dalam method ini akan membuat tabel baru di database.
     */
    public function up(): void
    {
        Schema::create('resellers', function (Blueprint $table) {
            $table->id(); // Primary key auto increment
            $table->string('nama_lengkap'); // Nama lengkap reseller
            $table->string('no_identitas')->nullable(); // Nomor identitas (misalnya NIK)
            $table->string('telepon')->nullable(); // Nomor telepon reseller
            $table->text('alamat')->nullable(); // Alamat lengkap reseller
            $table->string('username')->unique(); // Username unik untuk login
            $table->string('password'); // Password terenkripsi (bcrypt)
            $table->date('tgl_bergabung')->nullable(); // Tanggal bergabung reseller
            $table->decimal('limit_hutang', 15, 2)->default(0); // Batas maksimal hutang reseller
            $table->string('kode_unik')->default('0')->comment('Digunakan saat top saldo'); // Kode unik saat top-up saldo
            $table->json('hak_akses_router')->nullable(); // Hak akses router (format JSON)
            $table->json('hak_akses_server')->nullable(); // Hak akses server (format JSON)
            $table->json('hak_akses_profile')->nullable(); // Hak akses profile (format JSON)
            $table->timestamps(); // Kolom created_at dan updated_at
        });
    }

    /**
     * Batalkan migrasi (rollback).
     *
     * Method `down()` digunakan saat menjalankan:
     *   php artisan migrate:rollback
     * Tujuannya untuk menghapus tabel `resellers` dari database.
     */
    public function down(): void
    {
        Schema::dropIfExists('resellers'); // Hapus tabel resellers jika rollback
    }
};
