<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'subscription_id',
        'file_path', // ubah dari 'file_invoice' jadi 'file_path'
    ];

    public function subscription()
    {
        return $this->belongsTo(Subscription::class);
    }
}
