<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Info extends Model
{
    protected $fillable = [
        'nama_lengkap',    // nama user
        'telepon',      // nomor telepon
        'ip_address',
        'info_aktifitas',
        'tanggal_kejadian',
        'level',           // level user/admin
    ];
}


