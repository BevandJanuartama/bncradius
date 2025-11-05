<?php

namespace App\Http\Controllers;

use App\Models\Paket;
use Illuminate\Http\Request;

class PaketController extends Controller
{
    // Tampilkan semua paket
    public function index()
    {
        $pakets = Paket::all();
        return view('admin.paket.index', compact('pakets'));
    }

    // Tampilkan form tambah paket
    public function create()
    {
        return view('admin.paket.create'); // form create/edit gabung
    }

    // Simpan data paket baru
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required',
            'harga_bulanan' => 'required',
            'mikrotik' => 'required',
            'langganan' => 'required',
            'voucher' => 'required',
            'user_online' => 'required',
            'harga_tahunan' => 'required',
        ]);

        $booleanFields = [
            'vpn_tunnel',
            'vpn_remote',
            'whatsapp_gateway',
            'payment_gateway',
            'custom_domain',
            'client_area',
        ];

        foreach ($booleanFields as $field) {
            $validated[$field] = $request->has($field);
        }

        Paket::create($validated);

        return redirect()->route('paket.index')->with('success', 'Paket berhasil ditambahkan.');
    }

    // Tampilkan detail paket (optional)
    public function show(Paket $paket)
    {
        return view('admin.paket.show', compact('paket'));
    }

    // Tampilkan form edit paket
    public function edit($id)
    {
        $paket = Paket::findOrFail($id);
        return view('admin.paket.edit', compact('paket'));
    }

    // Update data paket
    public function update(Request $request, $id)
    {
        $paket = Paket::findOrFail($id);

        $validated = $request->validate([
            'nama' => 'required',
            'harga_bulanan' => 'required',
            'mikrotik' => 'required',
            'langganan' => 'required',
            'voucher' => 'required',
            'user_online' => 'required',
            'harga_tahunan' => 'required',
        ]);

        $booleanFields = [
            'vpn_tunnel',
            'vpn_remote',
            'whatsapp_gateway',
            'payment_gateway',
            'custom_domain',
            'client_area',
        ];

        foreach ($booleanFields as $field) {
            $validated[$field] = $request->has($field);
        }

        $paket->update($validated);

        return redirect()->route('paket.index')->with('success', 'Paket berhasil diperbarui.');
    }


    // Hapus paket
    public function destroy($id)
    {
        $paket = Paket::findOrFail($id);
        $paket->delete();

        return redirect()->route('paket.index')->with('success', 'Paket berhasil dihapus.');
    }

    public function showForUser()
{
    $pakets = Paket::all();
    return view('user.order', compact('pakets'));
}

}
