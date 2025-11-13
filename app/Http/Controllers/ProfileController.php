<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    /**
     * Tampilkan form profil user.
     * 
     * Mengirim data user yang sedang login ke view `user.account`
     * agar bisa menampilkan informasi profil dan form edit.
     */
    public function edit(Request $request): View
    {
        return view('user.account', [
            'user' => $request->user(), // ambil user dari sesi login
        ]);
    }

    /**
     * Update data profil user.
     * 
     * Menggunakan `ProfileUpdateRequest` untuk validasi otomatis.
     * Field `password` hanya diubah jika user mengisinya.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user(); // ambil user login saat ini

        // Isi data dengan hasil validasi
        $user->fill($request->validated());

        // Jika ada password baru, maka hash dan simpan
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        // Jika email berubah, reset verifikasi email
        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        // Simpan perubahan ke database
        $user->save();

        // Kembali ke halaman profil dengan notifikasi sukses
        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Hapus akun user dari sistem.
     * 
     * Melakukan validasi password terlebih dahulu agar aman.
     * Setelah itu logout, hapus akun, dan invalidasi sesi.
     */
    public function destroy(Request $request): RedirectResponse
    {
        // Pastikan user memasukkan password yang benar
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        // Logout sebelum akun dihapus
        Auth::logout();

        // Hapus akun user dari database
        $user->delete();

        // Bersihkan sesi login
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Arahkan kembali ke halaman utama
        return Redirect::to('/');
    }
}
