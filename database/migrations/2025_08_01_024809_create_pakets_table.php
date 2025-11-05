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
        Schema::create('pakets', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('harga_bulanan');
            $table->string('mikrotik');
            $table->string('langganan');
            $table->string('voucher');
            $table->string('user_online');
            $table->boolean('vpn_tunnel')->default(false);
            $table->boolean('vpn_remote')->default(false);
            $table->boolean('whatsapp_gateway')->default(false);
            $table->boolean('payment_gateway')->default(false);
            $table->boolean('custom_domain')->default(false);
            $table->boolean('client_area')->default(false);
            $table->string('harga_tahunan');
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pakets');
    }
};
