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
        $infos = Info::orderBy('tanggal_kejadian', 'desc')->paginate(10);
        return view('admin-sub.info', compact('infos'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'nama' => 'required|string|max:255',
            'telepon' => 'nullable|string|max:20',
            'info_aktifitas' => 'required|string',
            'tanggal_kejadian' => 'required|date',
            'level' => 'required|string',
        ]);

        // Simpan log
        Info::create([
            'nama_lengkap'    => $request->nama,
            'no_telepon'      => $request->telepon,       // optional, kalau kolom ada
            'ip_address'      => $request->ip() ?? $request->ip_address,
            'info_aktifitas'  => $request->info_aktifitas,
            'tanggal_kejadian'=> $request->tanggal_kejadian,
            'level'           => $request->level,
        ]);

        return redirect()->route('info.index')->with('success', 'Log berhasil disimpan');
    }


    /**
     * Display the specified resource.
     */
    public function show(Info $info)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Info $info)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Info $info)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroyAll()
    {
        // Hapus semua log dan reset auto-increment
        \App\Models\Info::truncate();

        return redirect()->route('info.index')
                        ->with('success', 'Semua log berhasil dihapus');
    }
}
