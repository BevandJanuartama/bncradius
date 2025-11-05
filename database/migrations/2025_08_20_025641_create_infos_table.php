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
    Schema::create('infos', function (Blueprint $table) {
        $table->id();
        $table->string('nama_lengkap');   
        $table->string('telepon')->nullable();   // kolom telepon
        $table->string('ip_address');     
        $table->string('info_aktifitas'); 
        $table->timestamp('tanggal_kejadian');
        $table->string('level')->nullable(); 
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('infos');
    }
};
