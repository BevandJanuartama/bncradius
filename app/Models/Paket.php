<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Model: Paket
 *
 * Model ini merepresentasikan tabel `pakets` di database.
 * Setiap paket berisi detail fitur dan harga yang ditawarkan
 * seperti harga bulanan, tahunan, dan layanan tambahan.
 */
class Paket extends Model
{
    use HasFactory; // Mengaktifkan fitur factory untuk model ini

    /**
     * Kolom yang dapat diisi secara mass-assignment.
     * Field-field ini bisa diisi langsung menggunakan create() atau update().
     */
    protected $fillable = [
        'nama',                // Nama paket langganan
        'harga_bulanan',       // Harga langganan per bulan
        'mikrotik',            // Status atau akses fitur Mikrotik
        'langganan',           // Jenis langganan atau deskripsi
        'voucher',             // Dukungan fitur voucher
        'user_online',         // Jumlah user online atau limit
        'vpn_tunnel',          // Ketersediaan fitur VPN Tunnel
        'vpn_remote',          // Ketersediaan fitur VPN Remote
        'whatsapp_gateway',    // Apakah termasuk WhatsApp Gateway
        'payment_gateway',     // Apakah mendukung Payment Gateway
        'custom_domain',       // Apakah bisa menggunakan domain custom
        'client_area',         // Fitur client area tersedia atau tidak
        'harga_tahunan',       // Harga langganan per tahun
    ];
}
