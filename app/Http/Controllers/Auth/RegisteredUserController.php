<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        $captcha = rand(10000, 99999);
        Session::put('captcha_register', $captcha);

        return view('auth.register', ['captcha' => $captcha]);
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'telepon' => 'required|string|max:20|unique:users,telepon',
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'captcha' => ['required', 'digits:5', function ($attribute, $value, $fail) {
                if ($value != session('captcha_register')) {
                    $fail('Captcha tidak sesuai.');
                }
            }],
        ]);

        // Hapus captcha setelah dipakai
        Session::forget('captcha_register');

        $user = User::create([
            'name' => $request->name,
            'telepon' => $request->telepon,
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));
        Auth::login($user);

        return redirect()->route('user.instance');
    }

    /**
     * Display subadmin form with user list
     */
    public function createSubadmin(): View
    {
        // Ambil semua user kecuali level 'user' biasa
        $users = User::whereIn('level', ['administrator', 'keuangan', 'teknisi', 'operator'])
                    ->orderBy('created_at', 'desc')
                    ->get();

        return view('admin-sub.admin', compact('users')); // kirim data users ke view
    }

    /**
     * Store subadmin
     */
    public function storeSubadmin(Request $request): RedirectResponse
    {
        try {
            // Log input data untuk debugging
            Log::info('Subadmin creation attempt', $request->all());
            
            // Validasi input
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'telepon' => 'required|string|max:20|unique:users,telepon',
                'password' => ['required', 'confirmed', Rules\Password::defaults()],
                'level' => 'required|in:administrator,keuangan,teknisi,operator',
            ]);

            Log::info('Validation passed', $validated);

            // Buat user baru
            $user = User::create([
                'name' => $validated['name'],
                'telepon' => $validated['telepon'],
                'password' => Hash::make($validated['password']),
                'level' => $validated['level'],
            ]);

            Log::info('User created successfully', ['user_id' => $user->id]);

            return redirect()->route('subadmin.create')->with('success', 'Subadmin berhasil ditambahkan dengan ID: ' . $user->id);
            
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Validation failed', ['errors' => $e->errors()]);
            return back()->withErrors($e->errors())->withInput();
            
        } catch (\Exception $e) {
            Log::error('Error creating subadmin', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);
            
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Show edit form for subadmin
     */
    public function editSubadmin($id): View
    {
        $user = User::findOrFail($id);
        
        // Pastikan hanya subadmin yang bisa diedit
        if (!in_array($user->level, ['administrator', 'keuangan', 'teknisi', 'operator'])) {
            abort(404, 'User tidak dapat diedit');
        }

        $users = User::whereIn('level', ['administrator', 'keuangan', 'teknisi', 'operator'])
                    ->orderBy('created_at', 'desc')
                    ->get();

        return view('admin-sub.edit', compact('user', 'users'));
    }

    /**
     * Update subadmin
     */
    public function updateSubadmin(Request $request, $id): RedirectResponse
    {
        $user = User::findOrFail($id);
        
        try {
            // Validasi input
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'telepon' => 'required|string|max:20|unique:users,telepon,' . $id,
                'password' => ['nullable', 'confirmed', Rules\Password::defaults()],
                'level' => 'required|in:administrator,keuangan,teknisi,operator',
            ]);

            // Update data user
            $updateData = [
                'name' => $validated['name'],
                'telepon' => $validated['telepon'],
                'level' => $validated['level'],
            ];

            // Update password jika diisi
            if (!empty($validated['password'])) {
                $updateData['password'] = Hash::make($validated['password']);
            }

            $user->update($updateData);

            Log::info('User updated successfully', ['user_id' => $user->id]);

            return redirect()->route('subadmin.create')->with('success', 'Subadmin "' . $user->name . '" berhasil diupdate');
            
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Validation failed', ['errors' => $e->errors()]);
            return back()->withErrors($e->errors())->withInput();
            
        } catch (\Exception $e) {
            Log::error('Error updating subadmin', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);
            
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Delete subadmin
     */
    public function deleteSubadmin($id): RedirectResponse
    {
        try {
            $user = User::findOrFail($id);
            
            // Pastikan hanya subadmin yang bisa dihapus
            if (!in_array($user->level, ['administrator', 'keuangan', 'teknisi', 'operator'])) {
                return back()->with('error', 'User ini tidak dapat dihapus');
            }

            // Jangan biarkan user menghapus dirinya sendiri
            if ($user->id === Auth::id()) {
                return back()->with('error', 'Anda tidak dapat menghapus akun Anda sendiri');
            }

            $userName = $user->name;
            $user->delete();

            Log::info('User deleted successfully', ['user_id' => $id, 'user_name' => $userName]);

            return redirect()->route('subadmin.create')->with('success', "Subadmin '$userName' berhasil dihapus");
            
        } catch (\Exception $e) {
            Log::error('Error deleting subadmin', [
                'message' => $e->getMessage(),
                'user_id' => $id
            ]);
            
            return back()->with('error', 'Terjadi kesalahan saat menghapus user');
        }
    }

    /**
     * Show admin dashboard/list (alias untuk createSubadmin)
     */
    public function adminDashboard(): View
    {
        return $this->createSubadmin();
    }
}