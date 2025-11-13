<?php

namespace App\Http\Controllers;

use App\Models\ProfileVoucher;
use Illuminate\Http\Request;

class ProfileVoucherController extends Controller
{
    // Method untuk menampilkan semua data profile voucher
    public function index()
    {
        // Mengambil semua data dari tabel profile_voucher
        $vouchers = ProfileVoucher::all();

        // Mengirim data ke view admin-sub/voucher/profile-voucher/index.blade.php
        return view('admin-sub.voucher.profile-voucher.index', compact('vouchers'));
    }

    // Method untuk menampilkan form tambah profile voucher
    public function create()
    {
        // Mengarahkan ke view form create
        return view('admin-sub.voucher.profile-voucher.create');
    }

    // Method untuk menyimpan data baru ke database
    public function store(Request $request)
    {
        // Validasi input dari form
        $validated = $request->validate([
            'nama_profile' => 'required|string|max:255', // nama profil wajib diisi, teks, maksimal 255 karakter
            'mikrotik_group' => 'required|string|max:255', // group mikrotik wajib diisi
            'shared' => 'nullable|integer|min:1', // jumlah shared boleh kosong, tapi jika diisi harus integer minimal 1
            'kuota' => 'nullable|integer|min:0', // kuota boleh kosong, tapi jika diisi harus angka >= 0
            'durasi' => 'nullable|integer|min:0', // durasi boleh kosong, tapi jika diisi harus angka >= 0
            'masa_aktif' => 'nullable|integer|min:1', // masa aktif boleh kosong, tapi jika diisi harus angka >= 1
            'hjk' => 'nullable|numeric|min:0', // harga jual ke konsumen (HJK), boleh kosong tapi harus angka >= 0
            'komisi' => 'nullable|numeric|min:0', // komisi untuk penjual, boleh kosong tapi harus angka >= 0
            'hpp' => 'nullable|numeric|min:0', // harga pokok penjualan (HPP), validasi angka >= 0
        ]);

        // Menyimpan data baru ke tabel profile_voucher
        // Menggabungkan hasil validasi dengan beberapa kolom tambahan yang tidak wajib
        $hasil = ProfileVoucher::create($validated + [
            'warna_voucher' => $request->warna_voucher, // warna voucher opsional
            'mikrotik_address_list' => $request->mikrotik_address_list, // address list mikrotik opsional
            'mikrotik_rate_limit' => $request->mikrotik_rate_limit, // rate limit mikrotik opsional
            'kuota_satuan' => $request->kuota_satuan ?? 'UNLIMITED', // default UNLIMITED jika tidak diisi
            'durasi_satuan' => $request->durasi_satuan ?? 'UNLIMITED', // default UNLIMITED jika tidak diisi
            'masa_aktif_satuan' => $request->masa_aktif_satuan ?? 'HARI', // default HARI jika tidak diisi
        ]);

        // Mengarahkan kembali ke halaman index dengan pesan sukses
        return redirect()->route('voucher.index')->with('success', 'Profile voucher berhasil ditambahkan.');

    }

    // Method untuk menampilkan halaman edit berdasarkan ID
    public function edit($id)
    {
        // Cari data berdasarkan ID, jika tidak ditemukan maka akan error 404
        $voucher = ProfileVoucher::findOrFail($id);

        // Mengirim data ke view edit
        return view('admin-sub.voucher.profile-voucher.edit', compact('voucher'));

        // Alternatif: kirim sebagai JSON (dikomentari)
        // return response()->json($voucher, 200);
    }

    // Method untuk memperbarui data profile voucher berdasarkan ID
    public function update(Request $request, $id)
    {
        // Cari data berdasarkan ID
        $voucher = ProfileVoucher::findOrFail($id);

        // Update semua data dengan input dari form
        $hasil = $voucher->update($request->all());

        // Redirect ke halaman index dengan pesan sukses
        return redirect()->route('voucher.index')->with('success', 'Profile voucher berhasil diperbarui.');

    }

    // Method untuk menghapus data berdasarkan ID
    public function destroy($id)
    {
        // Cari data berdasarkan ID
        $voucher = ProfileVoucher::findOrFail($id);

        // Hapus data dari database
        $voucher->delete();

        // Kembali ke halaman index dengan pesan sukses
        return redirect()->route('voucher.index')->with('success', 'Profile voucher berhasil dihapus.');
    }
}
