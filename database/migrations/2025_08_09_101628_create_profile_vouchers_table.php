<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Migration: Membuat tabel "profile_vouchers"
 *
 * Tabel ini menyimpan data profile voucher untuk jaringan Mikrotik.
 * Setiap profile berisi konfigurasi seperti kecepatan internet (rate limit),
 * masa aktif, kuota, dan harga jual voucher.
 * Data ini nantinya digunakan oleh sistem hotspot untuk pembuatan voucher otomatis.
 *
 * Dijalankan melalui perintah:
 *   php artisan migrate
 */
return new class extends Migration
{
    /**
     * Jalankan migrasi untuk membuat tabel profile_vouchers.
     *
     * Method `up()` berisi definisi kolom dan tipe datanya.
     * Ketika `php artisan migrate` dijalankan, tabel akan dibuat sesuai struktur berikut.
     */
    public function up(): void
    {
        Schema::create('profile_vouchers', function (Blueprint $table) {
            $table->id(); // Primary key auto increment

            $table->string('nama_profile'); // Nama profile voucher
            $table->string('warna_voucher')->nullable(); // Warna identifikasi voucher (contoh: #00FF00)

            $table->string('mikrotik_group'); // Nama group yang sesuai di Mikrotik
            $table->string('mikrotik_address_list')->nullable(); // Address list opsional di Mikrotik

            $table->string('mikrotik_rate_limit')->nullable(); // Limit kecepatan internet (contoh: 1M/1500k)
            $table->unsignedInteger('shared')->default(1); // Jumlah perangkat yang dapat berbagi koneksi

            $table->bigInteger('kuota')->default(0); // Total kuota data
            $table->string('kuota_satuan')->default('UNLIMITED'); // Satuan kuota (MB, GB, UNLIMITED)

            $table->bigInteger('durasi')->default(0); // Lama waktu koneksi
            $table->string('durasi_satuan')->default('UNLIMITED'); // Satuan durasi (menit, jam, UNLIMITED)

            $table->bigInteger('masa_aktif')->default(1); // Lama masa aktif voucher
            $table->string('masa_aktif_satuan')->default('HARI'); // Satuan masa aktif

            $table->decimal('hjk', 15, 2)->default(0); // Harga jual ke konsumen
            $table->decimal('komisi', 15, 2)->default(0); // Komisi untuk reseller
            $table->decimal('hpp', 15, 2)->default(0); // Harga pokok penjualan

            $table->timestamps(); // Kolom created_at dan updated_at otomatis
        });
    }

    /**
     * Batalkan migrasi (rollback).
     *
     * Method `down()` akan dijalankan saat:
     *   php artisan migrate:rollback
     * Tujuannya menghapus tabel profile_vouchers dari database.
     */
    public function down(): void
    {
        Schema::dropIfExists('profile_vouchers'); // Hapus tabel jika rollback
    }
};
