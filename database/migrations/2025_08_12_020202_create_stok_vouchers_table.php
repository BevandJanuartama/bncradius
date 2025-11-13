<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Migration: Membuat tabel "stok_vouchers"
 *
 * Tabel ini digunakan untuk menyimpan data voucher yang dimiliki oleh reseller.
 * Setiap voucher terkait dengan profil voucher dan reseller, serta menyimpan
 * informasi harga, komisi, masa aktif, dan status koneksi voucher.
 *
 * File ini dijalankan melalui perintah artisan:
 *   php artisan migrate
 */
return new class extends Migration
{
    /**
     * Jalankan migrasi untuk membuat tabel stok_vouchers.
     */
    public function up(): void
    {
        Schema::create('stok_vouchers', function (Blueprint $table) {
            $table->id(); // Primary key otomatis

            // Relasi ke tabel lain
            $table->foreignId('reseller_id')->nullable()->constrained('resellers')->nullOnDelete(); // relasi ke reseller
            $table->foreignId('profile_voucher_id')->nullable()->constrained('profile_vouchers')->nullOnDelete(); // relasi ke profil voucher

            // Data utama voucher
            $table->string('username')->unique(); // username voucher unik
            $table->string('password'); // password voucher
            $table->string('router')->nullable(); // nama router terkait
            $table->string('server')->nullable(); // nama server mikrotik
            $table->string('outlet')->nullable(); // lokasi/outlet penjualan

            // Informasi harga & komisi
            $table->decimal('hpp', 15, 2)->default(0); // harga pokok pembelian
            $table->decimal('komisi', 15, 2)->default(0); // komisi reseller per voucher
            $table->decimal('hjk', 15, 2)->default(0); // harga jual ke konsumen
            $table->boolean('saldo')->default(true); // apakah potong saldo reseller

            // Informasi batch & kode pembuatan
            $table->string('admin')->nullable(); // admin pembuat voucher
            $table->string('kode')->nullable(); // kode batch atau identifikasi
            $table->string('prefix')->nullable(); // awalan kode voucher
            $table->integer('panjang_karakter')->default(6); // panjang karakter random
            $table->string('jenis_voucher')->nullable(); // jenis voucher, misal hotspot, pppoe
            $table->string('kode_kombinasi')->nullable(); // gabungan prefix + kode unik
            $table->integer('jumlah')->default(1); // jumlah voucher dalam batch

            // Total harga & komisi keseluruhan batch
            $table->decimal('total_komisi', 15, 2)->default(0); // total komisi batch
            $table->decimal('total_hpp', 15, 2)->default(0); // total harga pokok batch

            // Informasi penggunaan voucher
            $table->timestamp('tgl_aktif')->nullable(); // tanggal voucher diaktifkan
            $table->timestamp('tgl_expired')->nullable(); // tanggal kadaluarsa voucher
            $table->bigInteger('upload_bytes')->default(0); // total upload data
            $table->bigInteger('download_bytes')->default(0); // total download data
            $table->bigInteger('durasi_detik')->default(0); // total waktu pemakaian dalam detik
            $table->string('mac')->nullable(); // MAC address perangkat yang terhubung

            // Metadata pembuatan
            $table->timestamp('tgl_pembuatan')->nullable(); // waktu pembuatan voucher
            $table->timestamps(); // created_at & updated_at
        });
    }

    /**
     * Batalkan migrasi (hapus tabel stok_vouchers).
     */
    public function down(): void
    {
        Schema::dropIfExists('stok_vouchers');
    }
};
