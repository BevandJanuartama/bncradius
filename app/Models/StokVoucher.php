<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Model: StokVoucher
 *
 * Model ini merepresentasikan tabel `stok_vouchers`.
 * Berisi data voucher yang dimiliki reseller, termasuk harga, komisi,
 * masa aktif, dan relasinya ke reseller serta profile voucher.
 */
class StokVoucher extends Model
{
    use HasFactory; // Mengaktifkan fitur factory untuk model ini

    /**
     * Kolom yang dapat diisi secara mass-assignment.
     */
    protected $fillable = [
        'reseller_id',         // ID reseller pemilik voucher
        'profile_voucher_id',  // ID profile voucher terkait
        'username',            // Username voucher
        'password',            // Password voucher
        'router',              // Nama router yang digunakan
        'server',              // Nama server terkait
        'outlet',              // Nama outlet atau cabang
        'hpp',                 // Harga pokok pembelian
        'komisi',              // Komisi per voucher
        'hjk',                 // Harga jual konsumen
        'saldo',               // Status potong saldo
        'admin',               // Nama admin yang membuat
        'kode',                // Kode unik voucher
        'prefix',              // Awalan kode voucher
        'panjang_karakter',    // Panjang karakter voucher
        'jenis_voucher',       // Jenis voucher (misal: harian, mingguan)
        'kode_kombinasi',      // Kode kombinasi acak
        'jumlah',              // Jumlah voucher dibuat
        'total_komisi',        // Total komisi keseluruhan
        'total_hpp',           // Total harga pokok
        'tgl_aktif',           // Tanggal mulai aktif
        'tgl_expired',         // Tanggal kedaluwarsa
        'upload_bytes',        // Total upload dalam bytes
        'download_bytes',      // Total download dalam bytes
        'durasi_detik',        // Durasi koneksi dalam detik
        'mac',                 // Alamat MAC perangkat
        'tgl_pembuatan'        // Tanggal voucher dibuat
    ];

    /**
     * Relasi ke model Reseller (banyak voucher dimiliki satu reseller).
     */
    public function reseller()
    {
        return $this->belongsTo(Reseller::class);
    }

    /**
     * Relasi ke model ProfileVoucher (voucher mengikuti satu profile).
     */
    public function profileVoucher()
    {
        return $this->belongsTo(ProfileVoucher::class);
    }
}
