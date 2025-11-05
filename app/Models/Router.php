<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Router extends Model
{
    protected $fillable = [
        'nama_router',
        'tipe_koneksi',
        'ip_address',
        'secret',
        'online',
        'script_path',
        'snmp',
    ];
}

