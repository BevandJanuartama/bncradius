<?php

namespace App\Http\Controllers;

use App\Models\Paket;
use Illuminate\Http\Request;

class PaketController extends Controller
{
    // Tampilkan semua data paket di halaman admin
    public function index()
    {
        $pakets = Paket::all(); // ambil semua data paket dari database
        return view('admin.paket.index', compact('pakets')); // kirim ke view
    }

    // Tampilkan form untuk menambah paket baru
    public function create()
    {
        // View create/edit bisa digabung agar efisien
        return view('admin.paket.create');
    }

    //Simpan data paket baru ke database
    public function store(Request $request)
    {
        // Validasi input agar semua field penting terisi
        $validated = $request->validate([
            'nama' => 'required',
            'harga_bulanan' => 'required',
            'mikrotik' => 'required',
            'langganan' => 'required',
            'voucher' => 'required',
            'user_online' => 'required',
            'harga_tahunan' => 'required',
        ]);

        // Field boolean (checkbox) — akan bernilai true/false
        $booleanFields = [
            'vpn_tunnel',
            'vpn_remote',
            'whatsapp_gateway',
            'payment_gateway',
            'custom_domain',
            'client_area',
        ];

        // Setiap field boolean akan dicek apakah diaktifkan (true) atau tidak (false)
        foreach ($booleanFields as $field) {
            $validated[$field] = $request->has($field);
        }

        // Simpan data paket baru ke database
        Paket::create($validated);

        // Redirect kembali ke daftar paket dengan pesan sukses
        return redirect()->route('paket.index')->with('success', 'Paket berhasil ditambahkan.');
    }

    // Tampilkan detail satu paket (opsional)
    public function show(Paket $paket)
    {
        return view('admin.paket.show', compact('paket'));
    }

    //  Tampilkan form edit untuk mengubah data paket
    public function edit($id)
    {
        $paket = Paket::findOrFail($id); // cari data berdasarkan ID
        return view('admin.paket.edit', compact('paket'));
    }

    // Update data paket yang sudah ada
    public function update(Request $request, $id)
    {
        $paket = Paket::findOrFail($id);

        // Validasi input sebelum diupdate
        $validated = $request->validate([
            'nama' => 'required',
            'harga_bulanan' => 'required',
            'mikrotik' => 'required',
            'langganan' => 'required',
            'voucher' => 'required',
            'user_online' => 'required',
            'harga_tahunan' => 'required',
        ]);

        // Field boolean (checkbox)
        $booleanFields = [
            'vpn_tunnel',
            'vpn_remote',
            'whatsapp_gateway',
            'payment_gateway',
            'custom_domain',
            'client_area',
        ];

        // Ubah nilai checkbox menjadi true/false
        foreach ($booleanFields as $field) {
            $validated[$field] = $request->has($field);
        }

        // Update data di database
        $paket->update($validated);

        return redirect()->route('paket.index')->with('success', 'Paket berhasil diperbarui.');
    }

    //Hapus paket dari database
    public function destroy($id)
    {
        $paket = Paket::findOrFail($id);
        $paket->delete();

        return redirect()->route('paket.index')->with('success', 'Paket berhasil dihapus.');
    }

    //Tampilkan daftar paket untuk halaman user (misalnya halaman pemesanan)
    public function showForUser()
    {
        $pakets = Paket::all(); // ambil semua paket
        return view('user.order', compact('pakets')); // kirim ke view order user
    }
}
