<?php

namespace App\Http\Controllers;

use App\Models\Info;
use Illuminate\Http\Request;

class InfoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Ambil semua data info dari database, urutkan berdasarkan tanggal kejadian terbaru (desc)
        // dan tampilkan ke view 'admin-sub.info' dengan pagination 10 data per halaman
        $infos = Info::orderBy('tanggal_kejadian', 'desc')->paginate(10);
        return view('admin-sub.info', compact('infos'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Tidak digunakan karena form create mungkin tidak dipakai di sistem ini
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi input dari form
        $request->validate([
            'nama' => 'required|string|max:255',
            'telepon' => 'nullable|string|max:20',
            'info_aktifitas' => 'required|string',
            'tanggal_kejadian' => 'required|date',
            'level' => 'required|string',
        ]);

        // Simpan data log ke tabel info
        Info::create([
            'nama_lengkap'    => $request->nama,                    // nama pelapor
            'no_telepon'      => $request->telepon,                 // nomor telepon opsional
            'ip_address'      => $request->ip() ?? $request->ip_address, // ambil IP client otomatis
            'info_aktifitas'  => $request->info_aktifitas,          // isi aktivitas/log
            'tanggal_kejadian'=> $request->tanggal_kejadian,        // tanggal kejadian
            'level'           => $request->level,                   // level user/admin
        ]);

        // Kembali ke halaman index info dengan pesan sukses
        return redirect()->route('info.index')->with('success', 'Log berhasil disimpan');
    }


    /**
     * Display the specified resource.
     */
    public function show(Info $info)
    {
        // Belum digunakan
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Info $info)
    {
        // Belum digunakan
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Info $info)
    {
        // Belum digunakan
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroyAll()
    {
        // Hapus semua data log pada tabel info dan reset auto-increment ke 0
        \App\Models\Info::truncate();

        // Redirect kembali ke halaman index dengan pesan sukses
        return redirect()->route('info.index')
                        ->with('success', 'Semua log berhasil dihapus');
    }
}
