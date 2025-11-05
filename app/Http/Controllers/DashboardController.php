<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request; // PASTIKAN INI ADA
use App\Models\Transaksi;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Models\Info; // TAMBAHKAN jika Anda ingin menggunakan model Info untuk log

class DashboardController extends Controller
{
    // UBAH TANDA TANGAN FUNGSI: Tambahkan Request $request
    public function index(Request $request)
    {
        // Waktu lokal
        $today = Carbon::now('Asia/Jakarta');
        $month = $today->month;
        $year  = $today->year;

        // ==============================
        // 🔹 1. PEMASUKAN HARI INI
        // ... (Tidak perlu diubah) ...
        // ==============================
        $pemasukanHariIni = Transaksi::where('kategori', 'pemasukan')
            ->whereDate('tanggal', $today)
            ->sum('total_bersih');

        // ==============================
        // 🔹 2. PENGELUARAN HARI INI
        // ... (Tidak perlu diubah) ...
        // ==============================
        $pengeluaranHariIni = Transaksi::where('kategori', 'pengeluaran')
            ->whereDate('tanggal', $today)
            ->sum('total_bersih');

        // ==============================
        // 🔹 3. PEMASUKAN BULAN INI
        // ... (Tidak perlu diubah) ...
        // ==============================
        $pemasukanBulanIni = Transaksi::where('kategori', 'pemasukan')
            ->whereMonth('tanggal', $month)
            ->whereYear('tanggal', $year)
            ->sum('total_bersih');

        // ==============================
        // 🔹 4. PENGELUARAN BULAN INI
        // ... (Tidak perlu diubah) ...
        // ==============================
        $pengeluaranBulanIni = Transaksi::where('kategori', 'pengeluaran')
            ->whereMonth('tanggal', $month)
            ->whereYear('tanggal', $year)
            ->sum('total_bersih');

        // ==============================
        // 🔹 5. PENDAPATAN BULAN INI
        // ... (Tidak perlu diubah) ...
        // ==============================
        $pendapatanBulanIni = $pemasukanBulanIni - $pengeluaranBulanIni;

        // ==============================
        // 🔹 6. GRAFIK PEMASUKAN HARIAN (bulan ini)
        // ... (Tidak perlu diubah) ...
        // ==============================
        $grafik = Transaksi::selectRaw('DAY(tanggal) as hari, SUM(total_bersih) as total')
            ->where('kategori', 'pemasukan')
            ->whereMonth('tanggal', $month)
            ->whereYear('tanggal', $year)
            ->groupBy('hari')
            ->orderBy('hari')
            ->get();

        // ==============================
        // 🔹 7. INFO LOG (Tambahkan filter berdasarkan Request)
        // ==============================
        $infosQuery = DB::table('infos'); // Mulai query

        // Logika filter tanggal dari route closure sebelumnya
        if ($request->filled('tanggal')) {
            $infosQuery->whereDate('tanggal_kejadian', $request->tanggal);
        }

        // Ambil data log
        $infos = $infosQuery
            ->orderBy('tanggal_kejadian', 'desc')
            ->limit(10)
            // Jika Anda ingin menggunakan pagination, gunakan: ->paginate(10)
            ->get();

        // ==============================
        // 🔹 8. KIRIM SEMUA KE VIEW
        // ==============================
        return view('admin-sub.dashboard', compact(
            'pemasukanHariIni',
            'pengeluaranHariIni',
            'pemasukanBulanIni',
            'pengeluaranBulanIni',
            'pendapatanBulanIni',
            'grafik',
            'infos'
        ));
    }
}
