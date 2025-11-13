<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Migration: Membuat tabel "transaksis"
 *
 * Tabel ini digunakan untuk mencatat seluruh transaksi keuangan,
 * baik pemasukan maupun pengeluaran, yang dilakukan oleh admin.
 * Data meliputi tanggal, jenis transaksi, jumlah, deskripsi, dan total nominal.
 *
 * Dijalankan melalui perintah:
 *   php artisan migrate
 */
return new class extends Migration
{
    /**
     * Jalankan migrasi untuk membuat tabel transaksis.
     */
    public function up(): void
    {
        Schema::create('transaksis', function (Blueprint $table) {
            $table->id(); // Primary key (auto increment)
            $table->date('tanggal'); // Tanggal transaksi terjadi
            $table->enum('kategori', ['pemasukan', 'pengeluaran']); // Jenis transaksi (masuk/keluar)
            $table->string('jenis')->nullable(); // Jenis detail transaksi, contoh: 'Voucher', 'Langganan', dsb.
            $table->foreignId('admin_id')->constrained('users')->onDelete('cascade'); // Relasi ke tabel users (admin pencatat)
            $table->text('deskripsi'); // Keterangan lengkap transaksi
            $table->integer('qty')->default(1); // Jumlah item dalam transaksi (default 1)
            $table->unsignedBigInteger('total_bersih'); // Total nominal transaksi (dalam Rupiah, tanpa simbol)
            $table->timestamps(); // Kolom created_at & updated_at
        });
    }

    /**
     * Batalkan migrasi (hapus tabel transaksis).
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksis');
    }
};
