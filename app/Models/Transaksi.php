<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Model: Transaksi
 *
 * Model ini merepresentasikan tabel `transaksis` di database.
 * Digunakan untuk mencatat data keuangan seperti pemasukan dan pengeluaran
 * yang dilakukan oleh admin (user). Setiap transaksi memiliki kategori,
 * jenis, deskripsi, jumlah, serta total nominal bersih.
 */
class Transaksi extends Model
{
    use HasFactory; // Mengaktifkan fitur factory untuk model ini

    /**
     * Kolom yang dapat diisi secara mass-assignment.
     *
     * Kolom ini menentukan data apa saja yang bisa langsung diisi
     * menggunakan metode seperti create() atau update().
     */
    protected $fillable = [
        'tanggal',        // Tanggal transaksi
        'kategori',       // Jenis transaksi: 'pemasukan' atau 'pengeluaran'
        'jenis',          // Tipe transaksi, contoh: 'Langganan', 'Beban Gaji', dll
        'admin_id',       // ID user (admin) yang mencatat transaksi
        'deskripsi',      // Keterangan transaksi
        'qty',            // Jumlah unit transaksi
        'total_bersih',   // Total nominal bersih dalam Rupiah
    ];

    /**
     * Kolom yang akan otomatis dikonversi ke tipe data tertentu.
     */
    protected $casts = [
        'tanggal' => 'date', // Otomatis ubah ke format Carbon (tanggal)
    ];

    /**
     * Relasi ke model User (admin).
     * Setiap transaksi dicatat oleh satu user (admin).
     */
    public function admin(): BelongsTo
    {
        return $this->belongsTo(User::class, 'admin_id');
    }
}
