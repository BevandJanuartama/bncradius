<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Migration: Membuat tabel "subscriptions"
 *
 * Tabel ini digunakan untuk menyimpan data langganan (subscription)
 * setiap pengguna terhadap paket layanan tertentu.
 * Setiap subscription terhubung ke user dan paket,
 * serta memiliki informasi perusahaan, harga, siklus, dan status pembayaran.
 *
 * Dijalankan melalui perintah:
 *   php artisan migrate
 */
return new class extends Migration
{
    /**
     * Jalankan migrasi untuk membuat tabel subscriptions.
     *
     * Method `up()` digunakan oleh Laravel untuk membangun struktur tabel baru.
     * Saat menjalankan `php artisan migrate`, instruksi di method ini akan dijalankan.
     */
    public function up(): void
    {
        Schema::create('subscriptions', function (Blueprint $table) {
            $table->id(); // Primary key auto increment

            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Relasi ke tabel users, hapus otomatis jika user dihapus

            $table->enum('data_center', ['IDC 3D JAKARTA', 'NCIX PEKANBAR']); // Lokasi data center hosting
            $table->string('subdomain_url')->unique(); // Subdomain unik milik client

            $table->foreignId('paket_id')->constrained()->onDelete('cascade'); // Relasi ke tabel pakets, hapus otomatis jika paket dihapus

            $table->enum('siklus', ['bulanan', 'tahunan']); // Jenis siklus langganan
            $table->decimal('harga', 10, 2); // Harga sesuai paket dan siklus

            $table->string('nama_perusahaan'); // Nama perusahaan pelanggan
            $table->string('provinsi'); // Provinsi perusahaan
            $table->string('kabupaten'); // Kabupaten/kota perusahaan
            $table->text('alamat'); // Alamat lengkap perusahaan
            $table->string('telepon'); // Nomor telepon perusahaan

            $table->boolean('setuju')->default(false); // Status persetujuan syarat & ketentuan
            $table->enum('status', ['dibayar', 'belum dibayar'])->default('belum dibayar'); // Status pembayaran

            $table->timestamps(); // Kolom created_at dan updated_at
        });
    }

    /**
     * Batalkan migrasi (rollback).
     *
     * Method `down()` dijalankan saat menjalankan:
     *   php artisan migrate:rollback
     * untuk menghapus tabel subscriptions dari database.
     */
    public function down(): void
    {
        Schema::dropIfExists('subscriptions'); // Hapus tabel jika rollback
    }
};
