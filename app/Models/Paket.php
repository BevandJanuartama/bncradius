<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Paket extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'harga_bulanan',
        'mikrotik',
        'langganan',
        'voucher',
        'user_online',
        'vpn_tunnel',
        'vpn_remote',
        'whatsapp_gateway',
        'payment_gateway',
        'custom_domain',
        'client_area',
        'harga_tahunan',
    ];
}
