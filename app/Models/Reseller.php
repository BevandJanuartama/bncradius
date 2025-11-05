<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reseller extends Model
{
    use HasFactory;

    protected $table = 'resellers';

    protected $fillable = [
        'nama_lengkap',
        'no_identitas',
        'telepon',
        'alamat',
        'username',
        'password',
        'tgl_bergabung',
        'limit_hutang',
        'kode_unik',
        'hak_akses_router',
        'hak_akses_server',
        'hak_akses_profile',
    ];

    protected $casts = [
        'hak_akses_router' => 'array',
        'hak_akses_server' => 'array',
        'hak_akses_profile' => 'array',
        'tgl_bergabung' => 'date',
        'limit_hutang' => 'decimal:2',
    ];
}
