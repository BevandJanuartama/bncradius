<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StokVoucher extends Model
{
    use HasFactory;

    protected $fillable = [
        'reseller_id',
        'profile_voucher_id',
        'username',
        'password',
        'router',
        'server',
        'outlet',
        'hpp',
        'komisi',
        'hjk',
        'saldo',
        'admin',
        'kode',
        'prefix',
        'panjang_karakter',
        'jenis_voucher',
        'kode_kombinasi',
        'jumlah',
        'total_komisi',
        'total_hpp',
        'tgl_aktif',
        'tgl_expired',
        'upload_bytes',
        'download_bytes',
        'durasi_detik',
        'mac',
        'tgl_pembuatan'
    ];

    public function reseller()
    {
        return $this->belongsTo(Reseller::class);
    }

    public function profileVoucher()
    {
        return $this->belongsTo(ProfileVoucher::class);
    }
}
