<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Model: Reseller
 *
 * Model ini merepresentasikan tabel `resellers` di database.
 * Menyimpan data detail reseller seperti identitas, kontak, hak akses,
 * serta pengaturan limit hutang dan tanggal bergabung.
 */
class Reseller extends Model
{
    use HasFactory; // Mengaktifkan fitur factory untuk model ini

    /**
     * Nama tabel yang digunakan oleh model ini.
     */
    protected $table = 'resellers';

    /**
     * Kolom yang dapat diisi secara mass-assignment.
     */
    protected $fillable = [
        'nama_lengkap',        // Nama lengkap reseller
        'no_identitas',        // Nomor identitas (KTP, SIM, dsb)
        'telepon',             // Nomor telepon reseller
        'alamat',              // Alamat lengkap
        'username',            // Username untuk login reseller
        'password',            // Password (harus di-hash saat disimpan)
        'tgl_bergabung',       // Tanggal bergabung menjadi reseller
        'limit_hutang',        // Batas maksimal hutang yang diperbolehkan
        'kode_unik',           // Kode unik identifikasi reseller
        'hak_akses_router',    // Daftar router yang bisa diakses (array)
        'hak_akses_server',    // Daftar server yang bisa diakses (array)
        'hak_akses_profile',   // Daftar profil voucher yang bisa diakses (array)
    ];

    /**
     * Konversi tipe data otomatis saat diambil/dikirim ke database.
     */
    protected $casts = [
        'hak_akses_router' => 'array',   // Disimpan dalam format JSON di database
        'hak_akses_server' => 'array',   // Disimpan dalam format JSON di database
        'hak_akses_profile' => 'array',  // Disimpan dalam format JSON di database
        'tgl_bergabung' => 'date',       // Otomatis diperlakukan sebagai objek tanggal
        'limit_hutang' => 'decimal:2',   // Format angka dengan dua angka desimal
    ];
}
