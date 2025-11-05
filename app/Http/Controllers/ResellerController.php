<?php

namespace App\Http\Controllers;

use App\Models\Reseller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ResellerController extends Controller
{
    // Menampilkan semua reseller
    public function index()
    {
        $resellers = Reseller::paginate(10);
        return view('admin-sub.resellers.index', compact('resellers'));
    }

    // Form tambah reseller
    public function create()
    {
        return view('admin-sub.resellers.create');
    }

    // Simpan reseller baru
    public function store(Request $request)
    {
        $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:resellers',
            'password' => 'required|string|min:6',
        ]);

        Reseller::create([
            'nama_lengkap' => $request->nama_lengkap,
            'no_identitas' => $request->no_identitas,
            'telepon' => $request->telepon,
            'alamat' => $request->alamat,
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'tgl_bergabung' => $request->tgl_bergabung,
            'limit_hutang' => $request->limit_hutang ?? 0,
            'kode_unik' => $request->kode_unik ?? '0',
            'hak_akses_router' => implode(',', $request->hak_akses_router ?? []),
            'hak_akses_server' => implode(',', $request->hak_akses_server ?? []),
            'hak_akses_profile' => implode(',', $request->hak_akses_profile ?? []),
        ]);

        return redirect()->route('resellers.index')->with('success', 'Reseller berhasil ditambahkan.');

        // return response()->json([
            // "status" => 202,
            // "message" => "Success",
            // "data" => $hasil
            // ]);
    }


    // Form edit reseller
    public function edit($id)
    {
        $reseller = Reseller::findOrFail($id);
        return view('admin-sub.resellers.edit', compact('reseller'));
    }

    // Update reseller
    public function update(Request $request, $id)
    {
        $reseller = Reseller::findOrFail($id);

        $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:resellers,username,' . $reseller->id,
        ]);

        $hasil = $reseller->update([
            'nama_lengkap' => $request->nama_lengkap,
            'no_identitas' => $request->no_identitas,
            'telepon' => $request->telepon,
            'alamat' => $request->alamat,
            'username' => $request->username,
            'password' => $request->password ? Hash::make($request->password) : $reseller->password,
            'tgl_bergabung' => $request->tgl_bergabung,
            'limit_hutang' => $request->limit_hutang ?? 0,
            'kode_unik' => $request->kode_unik ?? '0',
            'hak_akses_router' => implode(',', $request->hak_akses_router ?? []),
            'hak_akses_server' => implode(',', $request->hak_akses_server ?? []),
            'hak_akses_profile' => implode(',', $request->hak_akses_profile ?? []),
        ]);

        return redirect()->route('resellers.index')->with('success', 'Reseller berhasil diperbarui.');

        // return response()->json([
        // "status" => 202,
        // "message" => "Success",
        // "data" => $hasil
        // ]);
    }


    // Hapus reseller
    public function destroy($id)
    {
        $reseller = Reseller::findOrFail($id);
        $reseller->delete();

        return redirect()->route('resellers.index')->with('success', 'Reseller berhasil dihapus.');
    }
}
