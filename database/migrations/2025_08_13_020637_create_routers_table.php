<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Migration: Membuat tabel "routers"
 *
 * Tabel ini digunakan untuk menyimpan data router yang terhubung ke sistem.
 * Setiap router memiliki tipe koneksi (IP Public atau VPN Radius), status online,
 * serta konfigurasi tambahan seperti SNMP dan script path.
 *
 * File ini dijalankan melalui perintah artisan:
 *   php artisan migrate
 */
return new class extends Migration
{
    /**
     * Jalankan migrasi untuk membuat tabel routers.
     */
    public function up(): void
    {
        Schema::create('routers', function (Blueprint $table) {
            $table->id(); // Primary key otomatis

            $table->string('nama_router'); // nama unik router
            $table->enum('tipe_koneksi', ['ip_public', 'vpn_radius']); // jenis koneksi router
            $table->string('ip_address')->nullable(); // alamat IP router
            $table->string('secret')->nullable(); // password rahasia VPN
            $table->boolean('online')->default(false); // status router (online/offline)
            $table->string('script_path')->nullable(); // path file script router
            $table->string('snmp')->nullable(); // SNMP community atau informasi monitoring
            $table->timestamps(); // created_at & updated_at
        });
    }

    /**
     * Batalkan migrasi (hapus tabel routers).
     */
    public function down(): void
    {
        Schema::dropIfExists('routers');
    }
};
