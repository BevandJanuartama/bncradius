<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Model: Info
 *
 * Model ini merepresentasikan tabel `infos` di database.
 * Digunakan untuk menyimpan informasi log atau catatan aktivitas
 * user maupun admin, seperti login, perubahan data, atau tindakan penting lainnya.
 */
class Info extends Model
{
    /**
     * Kolom yang dapat diisi secara mass-assignment.
     */
    protected $fillable = [
        'nama_lengkap',     // Nama lengkap pengguna
        'telepon',          // Nomor telepon pengguna
        'ip_address',       // Alamat IP aktivitas
        'info_aktifitas',   // Deskripsi aktivitas yang dilakukan
        'tanggal_kejadian', // Waktu terjadinya aktivitas
        'level',            // Level pengguna 
    ];
}
