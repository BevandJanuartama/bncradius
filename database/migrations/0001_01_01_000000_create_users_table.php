<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Migration ini berfungsi untuk membuat tiga tabel utama:
 * 1. users — menyimpan data pengguna sistem
 * 2. password_reset_tokens — menyimpan token untuk reset password via nomor telepon
 * 3. sessions — menyimpan data sesi login pengguna
 *
 * Migration ini dijalankan otomatis dengan perintah:
 *   php artisan migrate
 */
return new class extends Migration
{
    /**
     * Jalankan proses migrasi.
     *
     * Method `up()` berisi instruksi untuk membuat tabel baru di database.
     * Saat perintah "php artisan migrate" dijalankan, semua tabel ini akan dibuat.
     */
    public function up(): void
    {
        /**
         * ==============================
         * TABEL: users
         * ==============================
         * Menyimpan data utama pengguna aplikasi.
         * Setiap user memiliki nama, nomor telepon unik, password, dan level akses.
         */
        Schema::create('users', function (Blueprint $table) {
            $table->id(); // Primary key (auto increment)

            $table->string('name'); // Nama lengkap pengguna

            $table->string('telepon')->unique(); // Nomor telepon unik untuk login (pengganti email)

            $table->string('password'); // Password terenkripsi (bcrypt)

            $table->string('level')->default('user'); // Level akses (user / admin)

            $table->rememberToken(); // Token untuk "remember me" saat login

            $table->timestamps(); // Kolom created_at dan updated_at otomatis
        });

        /**
         * ==============================
         * TABEL: password_reset_tokens
         * ==============================
         * Menyimpan token untuk proses reset password berbasis nomor telepon.
         * Token ini digunakan sementara saat user melakukan lupa password.
         */
        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('telepon')->primary(); // Nomor telepon sebagai kunci utama

            $table->string('token'); // Token unik untuk reset password

            $table->timestamp('created_at')->nullable(); // Waktu token dibuat
        });

        /**
         * ==============================
         * TABEL: sessions
         * ==============================
         * Menyimpan data sesi login pengguna agar bisa dikelola (logout, session timeout, dll).
         * Laravel menggunakan tabel ini saat fitur session berbasis database diaktifkan.
         */
        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary(); // ID sesi unik

            $table->foreignId('user_id')->nullable()->index(); // Relasi ke tabel users

            $table->string('ip_address', 45)->nullable(); // IP address user

            $table->text('user_agent')->nullable(); // Informasi browser atau device

            $table->longText('payload'); // Data sesi yang disimpan
            
            $table->integer('last_activity')->index(); // Waktu aktivitas terakhir user (timestamp)
        });
    }

    /**
     * Batalkan migrasi (rollback).
     *
     * Method `down()` digunakan saat menjalankan:
     *   php artisan migrate:rollback
     * untuk menghapus semua tabel yang dibuat oleh `up()`.
     */
    public function down(): void
    {
        Schema::dropIfExists('users'); // Hapus tabel users
        Schema::dropIfExists('password_reset_tokens'); // Hapus tabel token reset password
        Schema::dropIfExists('sessions'); // Hapus tabel sessions
    }
};
