<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;

class TransaksiController extends Controller
{
    /**
     * 📄 INDEX
     * Menampilkan halaman utama daftar transaksi + menghitung statistik bulanan
     */
    public function index()
    {
        // Tentukan rentang tanggal untuk bulan berjalan
        $startOfMonth = Carbon::now()->startOfMonth();
        $endOfMonth = Carbon::now()->endOfMonth();

        // Ambil semua data transaksi beserta relasi admin
        $transaksi = Transaksi::with('admin')
            ->orderBy('tanggal', 'desc')
            ->get()
            ->map(function ($t) {
                // Tambahkan field admin_name agar tidak error jika relasi admin kosong
                $t->admin_name = $t->admin->name ?? 'Sistem';
                // Format tanggal jadi hanya 'Y-m-d'
                $t->tanggal = Carbon::parse($t->tanggal)->format('Y-m-d');
                return $t;
            });

        // Filter transaksi hanya untuk bulan berjalan
        $currentMonthData = $transaksi->filter(function ($t) use ($startOfMonth, $endOfMonth) {
            $tanggal = Carbon::parse($t->tanggal);
            return $tanggal->between($startOfMonth, $endOfMonth);
        });

        // Hitung total pemasukan dan pengeluaran bulan ini
        $totalPemasukan = $currentMonthData
            ->filter(fn($t) => $t->kategori === 'pemasukan')
            ->sum('total_bersih');

        $totalPengeluaran = $currentMonthData
            ->filter(fn($t) => $t->kategori === 'pengeluaran')
            ->sum('total_bersih');

        // Hitung pendapatan bersih
        $pendapatan = $totalPemasukan - $totalPengeluaran;

        // Kirim data ke view Blade
        return view('admin-sub.transaksi', compact('transaksi', 'totalPemasukan', 'totalPengeluaran', 'pendapatan'));
    }

    // ========================================================================================================
    /**
     * ➕ STORE
     * Menambahkan transaksi baru ke database (digunakan via AJAX)
     */
    public function store(Request $request)
    {
        // Validasi input pengguna
        $validator = Validator::make($request->all(), [
            'tanggal'   => 'required|date',
            'kategori'  => 'required|in:pemasukan,pengeluaran',
            'deskripsi' => 'required|string|max:255',
            'total'     => 'required|numeric|min:0', // Nama input dari JS = total
            'qty'       => 'required|integer|min:1',
            'jenis'     => 'nullable|string|max:255',
        ]);

        // Jika validasi gagal, kembalikan pesan error JSON
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        try {
            // Simpan data transaksi ke database
            $transaksi = Transaksi::create([
                'tanggal'      => $request->tanggal,
                'kategori'     => strtolower($request->kategori),
                'jenis'        => $request->jenis,
                'admin_id'     => Auth::id(),
                'admin_name'   => Auth::user()->name,
                'deskripsi'    => $request->deskripsi,
                'qty'          => $request->qty,
                'total_bersih' => $request->total,
            ]);

            // Kembalikan respon JSON agar bisa langsung ditambahkan ke tabel frontend (DataTables)
            return response()->json([
                'message'      => 'Transaksi berhasil ditambahkan.',
                'transaksi'    => $transaksi->load('admin'), // otomatis include relasi admin
                'admin_name'   => Auth::user()->name,
            ], 201);

        } catch (\Exception $e) {
            // Jika gagal menyimpan (error DB atau lainnya)
            return response()->json([
                'message' => 'Gagal menyimpan transaksi.',
                'error'   => $e->getMessage(),
            ], 500);
        }
    }

    // ========================================================================================================
    /**
     * 📝 UPDATE
     * Mengedit transaksi yang sudah ada (via AJAX)
     */
    public function update(Request $request, string $id)
    {
        // Validasi data yang diterima dari form
        $validator = Validator::make($request->all(), [
            'tanggal'       => 'required|date',
            'kategori'      => 'required|in:pemasukan,pengeluaran',
            'deskripsi'     => 'required|string|max:255',
            'total_bersih'  => 'required|numeric|min:0', // nama input dari form detail
            'qty'           => 'required|integer|min:1',
            'jenis'         => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Ambil data transaksi berdasarkan ID
        $transaksi = Transaksi::findOrFail($id);

        try {
            // Update data transaksi
            $transaksi->update([
                'tanggal'      => $request->tanggal,
                'kategori'     => strtolower($request->kategori),
                'jenis'        => $request->jenis,
                'deskripsi'    => $request->deskripsi,
                'qty'          => $request->qty,
                'total_bersih' => $request->total_bersih,
            ]);

            return response()->json([
                'message'    => 'Transaksi berhasil diperbarui!',
                'transaksi'  => $transaksi,
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Gagal memperbarui transaksi.',
                'error'   => $e->getMessage(),
            ], 500);
        }
    }

    // ========================================================================================================
    /**
     * 🗑️ DESTROY
     * Menghapus transaksi berdasarkan ID (digunakan oleh tombol hapus AJAX)
     */
    public function destroy(string $id)
    {
        try {
            // Cari data transaksi berdasarkan ID
            $transaksi = Transaksi::findOrFail($id);
            // Hapus dari database
            $transaksi->delete();

            return response()->json([
                'message' => 'Transaksi berhasil dihapus!',
                'id'      => $id,
            ], 200);

        } catch (\Exception $e) {
            // Jika gagal menghapus (misal: ID tidak ditemukan)
            return response()->json([
                'message' => 'Gagal menghapus transaksi.',
                'error'   => $e->getMessage(),
            ], 500);
        }
    }

    
}
