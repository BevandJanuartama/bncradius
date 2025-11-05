<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Validation\ValidationException;
use App\Models\Info;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        // Generate captcha angka dan simpan di session
        $captcha = rand(10000, 99999);
        session(['captcha_login' => $captcha]);

        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'telepon' => 'required|string',
            'password' => 'required|string',
            'captcha' => ['required', 'digits:5', function ($attribute, $value, $fail) {
                if ($value != session('captcha_login')) {
                    $fail('Captcha tidak sesuai.');
                }
            }],
        ]);

        // Hapus captcha dari session setelah dipakai
        session()->forget('captcha_login');

        if (!Auth::attempt(['telepon' => $request->telepon, 'password' => $request->password], $request->boolean('remember'))) {
            throw ValidationException::withMessages([
                'telepon' => __('Nomor telepon atau password salah.'),
            ]);
        }

        $request->session()->regenerate();

        // Ambil user yang sudah login
        $user = Auth::user();

        // Cari IP asli
        $ipAddress = $request->header('X-Forwarded-For')
            ?? $request->header('Client-Ip')
            ?? $request->ip();

        // Hanya log kalau level user ada di daftar berikut
        $levelsAllowed = ['administrator', 'keuangan', 'teknisi', 'operator'];

        if (in_array($user->level, $levelsAllowed)) {
            Info::create([
                'nama_lengkap'     => $user->nama ?? $user->name ?? $user->telepon,
                'telepon'          => $user->telepon,
                'ip_address'       => $ipAddress,
                'info_aktifitas'   => 'Berhasil login ke aplikasi',
                'tanggal_kejadian' => now(),
                'level'            => $user->level,
            ]);
        }

        // Redirect berdasarkan level
        if ($user->level === 'admin') {
            return redirect()->intended(route('admin.dashboard'));
        } elseif (in_array($user->level, ['administrator', 'teknisi', 'operator', 'keuangan'])) {
            return redirect()->intended(route('admin-sub.dashboard'));
        } else {
            return redirect()->intended(route('user.instance'));
        }
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
