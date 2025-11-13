<?php

namespace App\Http\Controllers;

use App\Models\StokVoucher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StokVoucherController extends Controller
{
    /**
     * Menampilkan daftar seluruh stok voucher beserta data relasinya.
     * Termasuk juga perhitungan total jumlah stok, total komisi, dan total nilai jual.
     */
    public function index()
    {
        // Ambil semua data voucher beserta relasinya (reseller dan profile)
        $stokVouchers = StokVoucher::with(['reseller', 'profileVoucher'])->get();

        // Hitung statistik untuk card summary di dashboard
        $jumlahStok = StokVoucher::count();           // Total jumlah voucher
        $totalKomisi = StokVoucher::sum('komisi');    // Total komisi semua voucher
        $totalNilaiJual = StokVoucher::sum('hjk');    // Total harga jual keseluruhan

        // Kirim data ke view
        return view('admin-sub.voucher.stok-voucher.index', compact(
            'stokVouchers',
            'jumlahStok',
            'totalKomisi',
            'totalNilaiJual'
        ));
    }

    /**
     * Menampilkan form pembuatan stok voucher baru.
     * Mengambil data reseller dan profile voucher untuk dropdown pilihan.
     */
    public function create()
    {
        $resellers = \App\Models\Reseller::orderBy('nama_lengkap')->get();
        $profiles  = \App\Models\ProfileVoucher::orderBy('nama_profile')->get();

        return view('admin-sub.voucher.stok-voucher.create', compact('resellers', 'profiles'));
    }

    /**
     * Menyimpan data stok voucher baru ke database.
     * Menghasilkan banyak voucher sekaligus berdasarkan jumlah yang dimasukkan user.
     */
    public function store(Request $request)
    {
        // Validasi input dari form
        $request->validate([
            'reseller_id' => 'nullable|exists:resellers,id',
            'profile_voucher_id' => 'required|exists:profile_vouchers,id',
            'prefix' => 'nullable|string|max:20',
            'kode_kombinasi' => 'required|string',
            'panjang_karakter' => 'required|integer|min:4|max:20',
            'jumlah' => 'required|integer|min:1|max:1000',
            'hpp' => 'required|numeric|min:0',
            'komisi' => 'required|numeric|min:0',
            'hjk' => 'required|numeric|min:0',
            'router' => 'nullable|string',
            'server' => 'nullable|string',
            'outlet' => 'nullable|string',
            'jenis_voucher' => 'required|string|in:username_password,username_only',
            'saldo' => 'required|in:YES,NO',
        ]);

        try {
            // Mulai transaksi database agar aman jika gagal di tengah
            DB::beginTransaction();

            $jumlah = $request->jumlah;
            // Ambil semua input kecuali jumlah (karena jumlah digunakan untuk looping)
            $baseData = $request->except(['jumlah']);
            // Konversi saldo YES/NO menjadi boolean
            $baseData['saldo'] = $request->saldo === 'YES' ? true : false;

            // Set atribut default untuk setiap voucher
            $baseData['admin'] = 'administrator';
            $baseData['mac'] = 'open';
            $baseData['tgl_aktif'] = now();
            $baseData['tgl_expired'] = now()->addMonths(4);
            $baseData['tgl_pembuatan'] = now();

            // Kode batch unik 10 digit acak untuk satu batch pembuatan voucher
            $kodeBatch = str_pad(mt_rand(0, 9999999999), 10, '0', STR_PAD_LEFT);
            $baseData['kode'] = $kodeBatch;

            // Hitung total komisi dan total HPP keseluruhan batch
            $totalKomisi = $request->komisi * $jumlah;
            $totalHpp = $request->hpp * $jumlah;

            $createdVouchers = []; // Menyimpan voucher yang berhasil dibuat
            $usedCodes = [];       // Menyimpan kode yang sudah digunakan agar tidak duplikat

            // Loop sebanyak jumlah voucher yang diminta
            for ($i = 0; $i < $jumlah; $i++) {
                // Generate kode unik untuk username
                do {
                    $kode = $this->generateKode($request->prefix, $request->kode_kombinasi, $request->panjang_karakter);
                } while (in_array($kode, $usedCodes) || StokVoucher::where('username', $kode)->exists());

                $usedCodes[] = $kode;
                $voucherData = $baseData;
                $voucherData['username'] = $kode;

                // Tentukan password sesuai jenis voucher
                if ($request->jenis_voucher === 'username_password') {
                    // Jika jenisnya sama, password = username
                    $voucherData['password'] = $kode;
                } else {
                    // Jika berbeda, buat password unik juga
                    do {
                        $password = $this->generateKode($request->prefix, $request->kode_kombinasi, $request->panjang_karakter);
                    } while ($password === $kode || in_array($password, $usedCodes));
                    $voucherData['password'] = $password;
                    $usedCodes[] = $password;
                }

                // Tambahkan data tambahan
                $voucherData['jumlah'] = 1;
                $voucherData['total_komisi'] = $request->komisi;
                $voucherData['total_hpp'] = $request->hpp;

                // Simpan voucher ke database
                $voucher = StokVoucher::create($voucherData);
                $createdVouchers[] = $voucher;
            }

            // Commit transaksi jika semua berhasil
            DB::commit();

            // Buat pesan sukses dengan informasi total HPP dan komisi
            $message = "Berhasil membuat {$jumlah} voucher dengan total HPP: " . number_format($totalHpp, 2) .
                    " dan total komisi: " . number_format($totalKomisi, 2);

            return redirect()->route('stokvoucher.index')->with('success', $message);

        } catch (\Exception $e) {
            // Rollback jika ada error
            DB::rollBack();
            return redirect()->back()
                ->withInput()
                ->with('error', 'Gagal membuat voucher: ' . $e->getMessage());
        }
    }

    /**
     * Fungsi pembantu untuk generate kode acak voucher.
     * Menggabungkan prefix (jika ada) dengan karakter acak dari kombinasi yang diberikan.
     */
    private function generateKode($prefix, $kombinasi, $length)
    {
        $length = max(1, $length);
        $random = '';

        // Bangkitkan karakter acak satu per satu
        for ($i = 0; $i < $length; $i++) {
            $random .= $kombinasi[rand(0, strlen($kombinasi) - 1)];
        }

        // Hasil akhir berupa prefix + string acak
        return ($prefix ?? '') . $random;
    }

    /**
     * Menampilkan detail voucher tertentu.
     */
    public function show(StokVoucher $stokVoucher)
    {
        return view('admin-sub.voucher.stok-voucher.show', compact('stokVoucher'));
    }

    /**
     * Menampilkan form edit voucher.
     */
    public function edit(StokVoucher $stokVoucher)
    {
        $resellers = \App\Models\Reseller::orderBy('nama_lengkap')->get();
        $profiles  = \App\Models\ProfileVoucher::orderBy('nama_profile')->get();

        return view('admin-sub.voucher.stok-voucher.edit', compact('stokVoucher', 'resellers', 'profiles'));
    }

    /**
     * Memperbarui data voucher yang sudah ada.
     */
    public function update(Request $request, StokVoucher $stokVoucher)
    {
        // Validasi input
        $request->validate([
            'username' => 'required|unique:stok_vouchers,username,' . $stokVoucher->id,
            'password' => 'required|string',
            'reseller_id' => 'nullable|exists:resellers,id',
            'profile_voucher_id' => 'required|exists:profile_vouchers,id',
            'hpp' => 'required|numeric|min:0',
            'komisi' => 'required|numeric|min:0',
            'hjk' => 'required|numeric|min:0',
            'saldo' => 'required|in:YES,NO',
            'router' => 'nullable|string',
            'server' => 'nullable|string',
            'outlet' => 'nullable|string',
        ]);

        // Ambil data request untuk update
        $updateData = $request->all();
        $updateData['saldo'] = $request->saldo === 'YES' ? true : false;

        // Update total komisi dan HPP per voucher
        $updateData['total_komisi'] = $request->komisi;
        $updateData['total_hpp'] = $request->hpp;

        $stokVoucher->update($updateData);

        return redirect()->route('stokvoucher.index')->with('success', 'Stok voucher berhasil diperbarui');
    }

    /**
     * Menghapus satu voucher.
     */
    public function destroy(StokVoucher $stokVoucher)
    {
        $stokVoucher->delete();
        return redirect()->route('stokvoucher.index')->with('success', 'Stok voucher berhasil dihapus');
    }

    /**
     * Menghapus beberapa voucher sekaligus (bulk delete).
     */
    public function bulkDestroy(Request $request)
    {
        $request->validate([
            'voucher_ids' => 'required|array',
            'voucher_ids.*' => 'exists:stok_vouchers,id'
        ]);

        // Hapus semua id yang dikirim
        StokVoucher::whereIn('id', $request->voucher_ids)->delete();

        return redirect()->route('stokvoucher.index')
            ->with('success', 'Berhasil menghapus ' . count($request->voucher_ids) . ' voucher');
    }
}
