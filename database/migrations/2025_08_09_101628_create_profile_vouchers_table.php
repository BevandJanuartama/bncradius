<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('profile_vouchers', function (Blueprint $table) {
            $table->id();

            $table->string('nama_profile');
            $table->string('warna_voucher')->nullable(); // misalnya hex color: #00FF00

            $table->string('mikrotik_group'); // harus sama dengan profile di mikrotik
            $table->string('mikrotik_address_list')->nullable();

            $table->string('mikrotik_rate_limit')->nullable(); // contoh: 1M/1500k ...
            $table->unsignedInteger('shared')->default(1);

            $table->bigInteger('kuota')->default(0);
            $table->string('kuota_satuan')->default('UNLIMITED'); // MB, GB, UNLIMITED

            $table->bigInteger('durasi')->default(0);
            $table->string('durasi_satuan')->default('UNLIMITED'); // jam, menit, UNLIMITED

            $table->bigInteger('masa_aktif')->default(1);
            $table->string('masa_aktif_satuan')->default('HARI');

            $table->decimal('hjk', 15, 2)->default(0); // harga jual ke konsumen
            $table->decimal('komisi', 15, 2)->default(0); // komisi reseller per voucher
            $table->decimal('hpp', 15, 2)->default(0);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('profile_vouchers');
    }
};
