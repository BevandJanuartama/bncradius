<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Model: Subscription
 *
 * Model ini merepresentasikan tabel `subscriptions`.
 * Berisi data langganan (subscription) dari user terhadap paket layanan tertentu,
 * lengkap dengan informasi perusahaan, lokasi, dan status langganan.
 */
class Subscription extends Model
{
    use HasFactory; // Mengaktifkan fitur factory untuk model ini

    /**
     * Kolom yang dapat diisi secara mass-assignment.
     */
    protected $fillable = [
        'user_id',          // ID user yang berlangganan
        'paket_id',         // ID paket yang dipilih
        'data_center',      // Lokasi data center server
        'subdomain_url',    // Subdomain unik milik user
        'siklus',           // Siklus pembayaran (bulanan/tahunan)
        'harga',            // Harga langganan
        'nama_perusahaan',  // Nama perusahaan pengguna layanan
        'provinsi',         // Provinsi tempat perusahaan
        'kabupaten',        // Kabupaten/kota perusahaan
        'alamat',           // Alamat lengkap
        'telepon',          // Nomor telepon perusahaan
        'setuju',           // Status persetujuan (true/false)
        'status',           // Status langganan (aktif, nonaktif, pending, dll.)
    ];

    /**
     * Relasi ke model User (setiap subscription dimiliki oleh satu user).
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi ke model Paket (setiap subscription terkait satu paket).
     */
    public function paket()
    {
        return $this->belongsTo(Paket::class);
    }

    /**
     * Relasi ke model Invoice (setiap subscription memiliki satu invoice).
     */
    public function invoice()
    {
        return $this->hasOne(Invoice::class);
    }
}
