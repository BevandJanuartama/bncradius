<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('routers', function (Blueprint $table) {
            $table->id();
            $table->string('nama_router');
            $table->enum('tipe_koneksi', ['ip_public', 'vpn_radius']);
            $table->string('ip_address')->nullable();
            $table->string('secret')->nullable(); // password rahasia VPN
            $table->boolean('online')->default(false); // status router
            $table->string('script_path')->nullable(); // lokasi file script yang bisa di-download
            $table->string('snmp')->nullable(); // SNMP community atau info lain
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('routers');
    }
};
