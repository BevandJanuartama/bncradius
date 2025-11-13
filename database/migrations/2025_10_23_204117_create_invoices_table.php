<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Migration: Membuat tabel "invoices"
 *
 * Tabel ini digunakan untuk menyimpan data lembar invoice
 * yang terhubung ke langganan (subscription) tertentu.
 * Setiap invoice menyimpan file bukti pembayaran (PDF / image) 
 * dan terhubung langsung dengan data subscription.
 *
 * Dijalankan melalui perintah:
 *   php artisan migrate
 */
return new class extends Migration {
    /**
     * Jalankan migrasi untuk membuat tabel invoices.
     */
    public function up(): void
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->id(); // Primary key (auto increment)
            $table->foreignId('subscription_id')->constrained('subscriptions')->onDelete('cascade'); 
            // Relasi ke tabel subscriptions (jika subscription dihapus, invoice ikut terhapus)
            $table->string('file_path'); // Lokasi file invoice (contoh: storage/invoices/inv123.pdf)
            $table->timestamps(); // Kolom created_at dan updated_at
        });
    }

    /**
     * Batalkan migrasi (hapus tabel invoices).
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices'); // Menghapus tabel invoices dari database
    }
};
