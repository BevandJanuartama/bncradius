<?php

// database/migrations/xxxx_create_transaksis_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('transaksis', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal');
            $table->enum('kategori', ['pemasukan', 'pengeluaran']);
            $table->string('jenis')->nullable(); // Contoh: 'Langganan', 'Voucher', 'Beban Gaji', dll.
            $table->foreignId('admin_id')->constrained('users')->onDelete('cascade'); // ID user yang mencatat
            $table->text('deskripsi');
            $table->integer('qty')->default(1);
            $table->unsignedBigInteger('total_bersih'); // Nilai total bersih dalam Rupiah (integer, tanpa Rp/titik)
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transaksis');
    }
};
