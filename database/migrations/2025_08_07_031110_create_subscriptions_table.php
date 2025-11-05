<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('subscriptions', function (Blueprint $table) {
            $table->id();

            // Relasi user
            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            // DATA INSTANCE
            $table->enum('data_center', ['IDC 3D JAKARTA', 'NCIX PEKANBARU']);
            $table->string('subdomain_url')->unique();

            // Tambah kolom paket
            $table->foreignId('paket_id')->constrained()->onDelete('cascade');

            $table->enum('siklus', ['bulanan', 'tahunan']);
            $table->decimal('harga', 10, 2); // sesuai paket + siklus

            // DATA PERUSAHAAN
            $table->string('nama_perusahaan');
            $table->string('provinsi'); // cukup simpan nama provinsi (string)
            $table->string('kabupaten'); // cukup simpan nama kabupaten/kota (string)
            $table->text('alamat');
            $table->string('telepon');
            $table->boolean('setuju')->default(false);
            $table->enum('status', ['dibayar', 'belum dibayar'])->default('belum dibayar');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('subscriptions');
    }
};

