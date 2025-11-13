<?php

namespace App\Http\Controllers;

use App\Models\Reseller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ResellerController extends Controller
{
    // Menampilkan semua data reseller
    public function index()
    {
        // Mengambil data reseller dari database dengan pagination (10 data per halaman)
        $resellers = Reseller::paginate(10);

        // Mengirim data reseller ke view admin-sub/resellers/index.blade.php
        return view('admin-sub.resellers.index', compact('resellers'));
    }

    // Menampilkan form untuk menambah reseller baru
    public function create()
    {
        // Menampilkan halaman form create reseller
        return view('admin-sub.resellers.create');
    }

    // Menyimpan reseller baru ke database
    public function store(Request $request)
    {
        // Validasi data dari form input
        $request->validate([
            'nama_lengkap' => 'required|string|max:255', // wajib diisi, teks, maksimal 255 karakter
            'username' => 'required|string|max:255|unique:resellers', // wajib unik di tabel resellers
            'password' => 'required|string|min:6', // wajib diisi, minimal 6 karakter
        ]);

        // Menyimpan data reseller baru ke database
        Reseller::create([
            'nama_lengkap' => $request->nama_lengkap, // nama lengkap reseller
            'no_identitas' => $request->no_identitas, // nomor identitas (opsional)
            'telepon' => $request->telepon, // nomor telepon (opsional)
            'alamat' => $request->alamat, // alamat reseller
            'username' => $request->username, // username unik reseller
            'password' => Hash::make($request->password), // password di-hash untuk keamanan
            'tgl_bergabung' => $request->tgl_bergabung, // tanggal bergabung
            'limit_hutang' => $request->limit_hutang ?? 0, // batas hutang, default 0 jika kosong
            'kode_unik' => $request->kode_unik ?? '0', // kode unik reseller, default "0"
            'hak_akses_router' => implode(',', $request->hak_akses_router ?? []), // hak akses router, dikonversi dari array ke string
            'hak_akses_server' => implode(',', $request->hak_akses_server ?? []), // hak akses server
            'hak_akses_profile' => implode(',', $request->hak_akses_profile ?? []), // hak akses profile
        ]);

        // Redirect ke halaman daftar reseller dengan pesan sukses
        return redirect()->route('resellers.index')->with('success', 'Reseller berhasil ditambahkan.');

        
    }

    // Menampilkan form edit reseller berdasarkan ID
    public function edit($id)
    {
        // Cari data reseller berdasarkan ID, jika tidak ditemukan akan error 404
        $reseller = Reseller::findOrFail($id);

        // Kirim data reseller ke view edit
        return view('admin-sub.resellers.edit', compact('reseller'));
    }

    // Memperbarui data reseller
    public function update(Request $request, $id)
    {
        // Cari reseller berdasarkan ID
        $reseller = Reseller::findOrFail($id);

        // Validasi data update
        $request->validate([
            'nama_lengkap' => 'required|string|max:255', // wajib diisi dan maksimal 255 karakter
            'username' => 'required|string|max:255|unique:resellers,username,' . $reseller->id, // username harus unik kecuali milik dirinya sendiri
        ]);

        // Update data reseller di database
        $hasil = $reseller->update([
            'nama_lengkap' => $request->nama_lengkap,
            'no_identitas' => $request->no_identitas,
            'telepon' => $request->telepon,
            'alamat' => $request->alamat,
            'username' => $request->username,
            // Jika password diisi, akan di-hash baru. Jika tidak, gunakan password lama.
            'password' => $request->password ? Hash::make($request->password) : $reseller->password,
            'tgl_bergabung' => $request->tgl_bergabung,
            'limit_hutang' => $request->limit_hutang ?? 0,
            'kode_unik' => $request->kode_unik ?? '0',
            'hak_akses_router' => implode(',', $request->hak_akses_router ?? []),
            'hak_akses_server' => implode(',', $request->hak_akses_server ?? []),
            'hak_akses_profile' => implode(',', $request->hak_akses_profile ?? []),
        ]);

        // Redirect kembali ke halaman index dengan pesan sukses
        return redirect()->route('resellers.index')->with('success', 'Reseller berhasil diperbarui.');

    }

    // Menghapus reseller berdasarkan ID
    public function destroy($id)
    {
        // Cari reseller berdasarkan ID
        $reseller = Reseller::findOrFail($id);

        // Hapus data reseller dari database
        $reseller->delete();

        // Redirect kembali dengan pesan sukses
        return redirect()->route('resellers.index')->with('success', 'Reseller berhasil dihapus.');
    }
}
