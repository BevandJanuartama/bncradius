<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Migration ini digunakan untuk membuat tabel "pakets"
 * yang berisi daftar paket layanan beserta fitur-fiturnya.
 *
 * Setiap paket memiliki informasi harga bulanan, harga tahunan,
 * batas penggunaan, serta status fitur seperti VPN, WhatsApp Gateway,
 * Payment Gateway, dan lain-lain.
 *
 * Migration ini dijalankan melalui perintah:
 *   php artisan migrate
 */
return new class extends Migration
{
    /**
     * Jalankan proses migrasi.
     *
     * Method ini berfungsi untuk membuat tabel "pakets" di database.
     * Semua kolom didefinisikan di dalam closure Schema::create().
     */
    public function up(): void
    {
        Schema::create('pakets', function (Blueprint $table) {
            $table->id(); 
            // Primary key otomatis dengan tipe BIGINT (auto increment)

            $table->string('nama');
            // Nama paket layanan (contoh: Basic, Premium, Ultimate)

            $table->string('harga_bulanan');
            // Harga langganan bulanan (dalam rupiah)

            $table->string('mikrotik');
            // Jumlah perangkat mikrotik yang bisa terhubung dalam paket ini

            $table->string('langganan');
            // Jumlah maksimum pelanggan/klien yang bisa dilayani

            $table->string('voucher');
            // Jumlah voucher atau kode akses yang disediakan

            $table->string('user_online');
            // Batas maksimum user online bersamaan

            // ============================
            // Kolom fitur tambahan (opsional)
            // Setiap kolom boolean merepresentasikan aktif/tidaknya fitur
            // ============================

            $table->boolean('vpn_tunnel')->default(false); // Apakah paket ini memiliki fitur VPN Tunnel (default: tidak aktif)

            $table->boolean('vpn_remote')->default(false); // Apakah mendukung VPN Remote Access

            $table->boolean('whatsapp_gateway')->default(false); // Apakah sudah termasuk fitur integrasi WhatsApp Gateway

            $table->boolean('payment_gateway')->default(false); // Apakah sudah termasuk fitur Payment Gateway untuk transaksi otomatis

            $table->boolean('custom_domain')->default(false); // Apakah pengguna bisa menggunakan domain kustom sendiri

            $table->boolean('client_area')->default(false); // Apakah paket menyediakan halaman client area (portal pelanggan)

            $table->string('harga_tahunan'); // Harga langganan tahunan (biasanya lebih murah dibanding bulanan)

            $table->timestamps(); // Menyimpan waktu pembuatan (created_at) dan pembaruan (updated_at)
        });
    }

    /**
     * Batalkan migrasi (rollback).
     *
     * Method ini akan dijalankan jika perintah:
     *   php artisan migrate:rollback
     * dieksekusi, untuk menghapus tabel "pakets".
     */
    public function down(): void
    {
        Schema::dropIfExists('pakets');
    }
};
