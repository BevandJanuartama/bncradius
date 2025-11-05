<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProfileVoucher extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_profile',
        'warna_voucher',
        'mikrotik_group',
        'mikrotik_address_list',
        'mikrotik_rate_limit',
        'shared',
        'kuota',
        'kuota_satuan',
        'durasi',
        'durasi_satuan',
        'masa_aktif',
        'masa_aktif_satuan',
        'hjk',
        'komisi',
        'hpp',
    ];
}
