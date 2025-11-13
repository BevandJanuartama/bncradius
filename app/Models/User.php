<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 * Model: User
 *
 * Model ini merepresentasikan tabel `users` di database.
 * User digunakan untuk autentikasi (login) dan memiliki atribut dasar
 * seperti nama, nomor telepon, password, dan level (role).
 */
class User extends Authenticatable
{
    use HasFactory, Notifiable; // Mengaktifkan fitur factory & notifikasi

    /**
     * Kolom yang dapat diisi secara mass-assignment.
     *
     * Kolom ini menentukan field mana saja yang boleh diisi
     * secara langsung melalui create() atau update().
     */
    protected $fillable = [
        'name',      // Nama user
        'telepon',   // Nomor telepon user
        'password',  // Password login user
        'level',     // Level user, misalnya 'admin' atau 'user'
    ];

    /**
     * Kolom yang disembunyikan saat model dikonversi ke array atau JSON.
     */
    protected $hidden = [
        'password',        // Menyembunyikan password dari output
        'remember_token',  // Token "remember me" untuk autentikasi
    ];

    /**
     * Tipe data otomatis (casting) untuk kolom tertentu.
     * Password dikonversi otomatis ke format hash.
     */
    protected function casts(): array
    {
        return [
            'password' => 'hashed', // Otomatis hash password sebelum disimpan
        ];
    }
}
