<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Model: Invoice
 *
 * Model ini merepresentasikan tabel `invoices` di database.
 * Setiap invoice terhubung ke satu data subscription dan menyimpan
 * informasi file path dari dokumen invoice terkait.
 */
class Invoice extends Model
{
    use HasFactory; // Mengaktifkan fitur factory untuk model ini

    /**
     * Kolom yang dapat diisi secara mass-assignment.
     */
    protected $fillable = [
        'subscription_id', // Relasi ke tabel subscriptions
        'file_path',       // Lokasi atau nama file invoice yang tersimpan
    ];

    /**
     * Relasi ke model Subscription.
     * Setiap invoice dimiliki oleh satu subscription.
     */
    public function subscription()
    {
        return $this->belongsTo(Subscription::class);
    }
}
