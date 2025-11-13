<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Model: ProfileVoucher
 *
 * Model ini merepresentasikan tabel `profile_vouchers` di database.
 * Data ini menyimpan detail profil voucher seperti pengaturan Mikrotik,
 * limit kuota, durasi, masa aktif, dan harga jual.
 */
class ProfileVoucher extends Model
{
    use HasFactory; // Mengaktifkan fitur factory untuk model ini

    /**
     * Kolom yang dapat diisi secara mass-assignment.
     * Digunakan saat membuat atau memperbarui data profil voucher.
     */
    protected $fillable = [
        'nama_profile',          // Nama profil voucher
        'warna_voucher',         // Warna tampilan voucher
        'mikrotik_group',        // Grup Mikrotik yang digunakan
        'mikrotik_address_list', // Address list di Mikrotik
        'mikrotik_rate_limit',   // Rate limit (kecepatan koneksi)
        'shared',                // Jumlah pengguna yang bisa berbagi voucher
        'kuota',                 // Jumlah kuota internet
        'kuota_satuan',          // Satuan kuota (MB/GB)
        'durasi',                // Lama waktu durasi koneksi
        'durasi_satuan',         // Satuan durasi (menit/jam/hari)
        'masa_aktif',            // Masa aktif voucher
        'masa_aktif_satuan',     // Satuan masa aktif (hari/bulan)
        'hjk',                   // Harga jual ke konsumen
        'komisi',                // Komisi untuk reseller/mitra
        'hpp',                   // Harga pokok penjualan
    ];
}
