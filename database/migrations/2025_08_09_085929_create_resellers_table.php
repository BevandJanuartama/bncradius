<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('resellers', function (Blueprint $table) {
            $table->id();
            $table->string('nama_lengkap');
            $table->string('no_identitas')->nullable(); // misalnya NIK internal
            $table->string('telepon')->nullable();
            $table->text('alamat')->nullable();
            $table->string('username')->unique();
            $table->string('password');
            $table->date('tgl_bergabung')->nullable();
            $table->decimal('limit_hutang', 15, 2)->default(0);
            $table->string('kode_unik')->default('0')->comment('Digunakan saat top saldo');

            // Hak akses - simpan array JSON
            $table->json('hak_akses_router')->nullable(); 
            $table->json('hak_akses_server')->nullable(); 
            $table->json('hak_akses_profile')->nullable(); 

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('resellers');
    }
};
