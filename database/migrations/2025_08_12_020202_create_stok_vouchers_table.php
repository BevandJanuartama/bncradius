<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('stok_vouchers', function (Blueprint $table) {
            $table->id();

            // Relasi
            $table->foreignId('reseller_id')->nullable()->constrained('resellers')->nullOnDelete();
            $table->foreignId('profile_voucher_id')->nullable()->constrained('profile_vouchers')->nullOnDelete();

            // Data voucher utama
            $table->string('username')->unique();
            $table->string('password');
            $table->string('router')->nullable();
            $table->string('server')->nullable();
            $table->string('outlet')->nullable();

            // Harga & komisi
            $table->decimal('hpp', 15, 2)->default(0); // Harga pokok pembelian
            $table->decimal('komisi', 15, 2)->default(0); // Komisi per voucher
            $table->decimal('hjk', 15, 2)->default(0); // Harga jual konsumen
            $table->boolean('saldo')->default(true); // Potong saldo (YES/NO)

            // Batch & kode
            $table->string('admin')->nullable();
            $table->string('kode')->nullable();
            $table->string('prefix')->nullable();
            $table->integer('panjang_karakter')->default(6);
            $table->string('jenis_voucher')->nullable();
            $table->string('kode_kombinasi')->nullable();
            $table->integer('jumlah')->default(1);

            // Total
            $table->decimal('total_komisi', 15, 2)->default(0);
            $table->decimal('total_hpp', 15, 2)->default(0);

            // Info tambahan
            $table->timestamp('tgl_aktif')->nullable();
            $table->timestamp('tgl_expired')->nullable();
            $table->bigInteger('upload_bytes')->default(0);
            $table->bigInteger('download_bytes')->default(0);
            $table->bigInteger('durasi_detik')->default(0);
            $table->string('mac')->nullable();

            // Tanggal pembuatan
            $table->timestamp('tgl_pembuatan')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('stok_vouchers');
    }
};
