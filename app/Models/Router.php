<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Model: Router
 *
 * Model ini merepresentasikan tabel `routers` di database.
 * Berisi informasi detail router seperti nama, tipe koneksi,
 * alamat IP, status online, serta data tambahan seperti SNMP dan script.
 */
class Router extends Model
{
    /**
     * Kolom yang dapat diisi secara mass-assignment.
     */
    protected $fillable = [
        'nama_router',   // Nama router
        'tipe_koneksi',  // Jenis koneksi (ip_public atau vpn_radius)
        'ip_address',    // Alamat IP router
        'secret',        // Password atau secret untuk koneksi VPN
        'online',        // Status online/offline router
        'script_path',   // Lokasi file script router (bisa diunduh)
        'snmp',          // SNMP community atau info tambahan
    ];
}
