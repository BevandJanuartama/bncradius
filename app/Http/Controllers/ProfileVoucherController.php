<?php

namespace App\Http\Controllers;

use App\Models\ProfileVoucher;
use Illuminate\Http\Request;

class ProfileVoucherController extends Controller
{
    public function index()
    {
        $vouchers = ProfileVoucher::all();
        return view('admin-sub.voucher.profile-voucher.index', compact('vouchers'));
    }

    public function create()
    {
        return view('admin-sub.voucher.profile-voucher.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_profile' => 'required|string|max:255',
            'mikrotik_group' => 'required|string|max:255',
            'shared' => 'nullable|integer|min:1',
            'kuota' => 'nullable|integer|min:0',
            'durasi' => 'nullable|integer|min:0',
            'masa_aktif' => 'nullable|integer|min:1',
            'hjk' => 'nullable|numeric|min:0',
            'komisi' => 'nullable|numeric|min:0',
            'hpp' => 'nullable|numeric|min:0', // ✅ Validasi HPP
        ]);

        $hasil = ProfileVoucher::create($validated + [
            'warna_voucher' => $request->warna_voucher,
            'mikrotik_address_list' => $request->mikrotik_address_list,
            'mikrotik_rate_limit' => $request->mikrotik_rate_limit,
            'kuota_satuan' => $request->kuota_satuan ?? 'UNLIMITED',
            'durasi_satuan' => $request->durasi_satuan ?? 'UNLIMITED',
            'masa_aktif_satuan' => $request->masa_aktif_satuan ?? 'HARI',
        ]);

        return redirect()->route('voucher.index')->with('success', 'Profile voucher berhasil ditambahkan.');



        // return response()->json([
        // "status" => 202,
        // "message" => "Success",
        // "data" => $hasil
        // ]);
    }

    public function edit($id)
    {
        $voucher = ProfileVoucher::findOrFail($id);
        return view('admin-sub.voucher.profile-voucher.edit', compact('voucher'));
        // return response()->json($voucher, 200);
    }

    public function update(Request $request, $id)
    {
        $voucher = ProfileVoucher::findOrFail($id);

        $hasil = $voucher->update($request->all());

        return redirect()->route('voucher.index')->with('success', 'Profile voucher berhasil diperbarui.');

        // return response()->json([
        // "status" => 202,
        // "message" => "Success",
        // "data" => $hasil
        // ]);
    }

    public function destroy($id)
    {
        $voucher = ProfileVoucher::findOrFail($id);
        $voucher->delete();

        return redirect()->route('voucher.index')->with('success', 'Profile voucher berhasil dihapus.');
    }
}
