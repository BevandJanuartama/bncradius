<?php

// app/Http/Controllers/TransaksiController.php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator; // Tambahkan ini untuk validasi manual jika perlu

class TransaksiController extends Controller
{
    /**
     * READ - Menampilkan halaman utama dan data awal
     */
    public function index()
    {
        $startOfMonth = Carbon::now()->startOfMonth();
        $endOfMonth = Carbon::now()->endOfMonth();

        // Ambil semua transaksi + relasi admin
        $transaksi = Transaksi::with('admin')
                               ->orderBy('tanggal', 'desc')
                               ->get()
                               ->map(function($t) {
                                   // Pastikan admin_name ada, untuk menghindari error di Blade jika relasi kosong
                                   $t->admin_name = $t->admin->name ?? 'Sistem';
                                   // kirim hanya tanggal ke view
                                   $t->tanggal = Carbon::parse($t->tanggal)->format('Y-m-d');
                                   return $t;
                               });

        // Hitungan statistik
        $currentMonthData = $transaksi->filter(function($t) use ($startOfMonth, $endOfMonth) {
            $tanggal = Carbon::parse($t->tanggal);
            return $tanggal->between($startOfMonth, $endOfMonth);
        });

        $totalPemasukan = $currentMonthData->filter(fn($t) => $t->kategori === 'pemasukan')->sum('total_bersih');
        $totalPengeluaran = $currentMonthData->filter(fn($t) => $t->kategori === 'pengeluaran')->sum('total_bersih');
        $pendapatan = $totalPemasukan - $totalPengeluaran;

        return view('admin-sub.transaksi', compact('transaksi', 'totalPemasukan', 'totalPengeluaran', 'pendapatan'));
    }

    // ----------------------------------------------------------------------------------------------------------------------

    /**
     * CREATE - Menyimpan transaksi baru (Dioptimalkan untuk AJAX) ➕
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'tanggal' => 'required|date',
            'kategori' => 'required|in:pemasukan,pengeluaran',
            'deskripsi' => 'required|string|max:255',
            // Nama input di AJAX adalah 'total', bukan 'total_bersih',
            // sesuaikan dengan data yang dikirim oleh JavaScript
            'total' => 'required|numeric|min:0',
            'qty' => 'required|integer|min:1',
            'jenis' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422); // Error Validasi
        }

        try {
            $transaksi = Transaksi::create([
                'tanggal' => $request->tanggal,
                'kategori' => strtolower($request->kategori),
                'jenis' => $request->jenis,
                'admin_id' => Auth::id(),
                'admin_name' => Auth::user()->name,
                'deskripsi' => $request->deskripsi,
                'qty' => $request->qty,
                // Pastikan nama kolom database sesuai:
                'total_bersih' => $request->total,
            ]);

            // Kembalikan data yang baru saja dibuat, agar frontend bisa menambahkannya ke DataTables
            return response()->json([
                'message' => 'Transaksi berhasil ditambahkan.',
                'transaksi' => $transaksi->load('admin'), // Load admin untuk nama
                'admin_name' => Auth::user()->name,
            ], 201); // 201 Created

        } catch (\Exception $e) {
            // Log error
            return response()->json(['message' => 'Gagal menyimpan transaksi.', 'error' => $e->getMessage()], 500);
        }
    }

    // ----------------------------------------------------------------------------------------------------------------------

    /**
     * UPDATE - Memperbarui transaksi yang ada (Dioptimalkan untuk AJAX) 📝
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'tanggal' => 'required|date',
            'kategori' => 'required|in:pemasukan,pengeluaran',
            'deskripsi' => 'required|string|max:255',
            // Nama input di AJAX adalah 'total_bersih' jika mengikuti form detail
            'total_bersih' => 'required|numeric|min:0',
            'qty' => 'required|integer|min:1',
            'jenis' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $transaksi = Transaksi::findOrFail($id);

        try {
            $transaksi->update([
                'tanggal' => $request->tanggal,
                'kategori' => strtolower($request->kategori),
                'jenis' => $request->jenis,
                'deskripsi' => $request->deskripsi,
                'qty' => $request->qty,
                'total_bersih' => $request->total_bersih,
            ]);

            return response()->json([
                'message' => 'Transaksi berhasil diperbarui!',
                'transaksi' => $transaksi,
            ], 200);

        } catch (\Exception $e) {
            return response()->json(['message' => 'Gagal memperbarui transaksi.', 'error' => $e->getMessage()], 500);
        }
    }

    // ----------------------------------------------------------------------------------------------------------------------

    /**
     * DELETE - Menghapus transaksi (Dioptimalkan untuk AJAX) 🗑️
     */
    public function destroy(string $id)
    {
        try {
            $transaksi = Transaksi::findOrFail($id);
            $transaksi->delete();

            return response()->json([
                'message' => 'Transaksi berhasil dihapus!',
                'id' => $id
            ], 200);

        } catch (\Exception $e) {
            return response()->json(['message' => 'Gagal menghapus transaksi.', 'error' => $e->getMessage()], 500);
        }
    }

    // ... (Fungsi show() dan Laporan tidak diubah)
}
