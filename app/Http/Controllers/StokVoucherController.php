<?php

namespace App\Http\Controllers;

use App\Models\StokVoucher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StokVoucherController extends Controller
{
    public function index()
    {
        // Ambil semua data voucher beserta relasinya
        $stokVouchers = StokVoucher::with(['reseller', 'profileVoucher'])->get();

        // === Data untuk card statistik ===
        $jumlahStok = StokVoucher::count();           // Jumlah total voucher
        $totalKomisi = StokVoucher::sum('komisi');    // Total komisi semua voucher
        $totalNilaiJual = StokVoucher::sum('hjk');    // Total harga jual semua voucher

        // Kirim semua data ke view
        return view('admin-sub.voucher.stok-voucher.index', compact(
            'stokVouchers',
            'jumlahStok',
            'totalKomisi',
            'totalNilaiJual'
        ));
    }



    public function create()
    {
        $resellers = \App\Models\Reseller::orderBy('nama_lengkap')->get();
        $profiles  = \App\Models\ProfileVoucher::orderBy('nama_profile')->get();

        return view('admin-sub.voucher.stok-voucher.create', compact('resellers', 'profiles'));
    }

    public function store(Request $request)
    {
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
            DB::beginTransaction();

            $jumlah = $request->jumlah;
            $baseData = $request->except(['jumlah']);
            $baseData['saldo'] = $request->saldo === 'YES' ? true : false;

            // Set otomatis untuk semua voucher batch
            $baseData['admin'] = 'administrator';
            $baseData['mac'] = 'open';
            $baseData['tgl_aktif'] = now();
            $baseData['tgl_expired'] = now()->addMonths(4);
            $baseData['tgl_pembuatan'] = now();

            // Generate kode batch 10 angka acak (1 kali generate untuk semua)
            $kodeBatch = str_pad(mt_rand(0, 9999999999), 10, '0', STR_PAD_LEFT);
            $baseData['kode'] = $kodeBatch;

            $totalKomisi = $request->komisi * $jumlah;
            $totalHpp = $request->hpp * $jumlah;

            $createdVouchers = [];
            $usedCodes = [];

            for ($i = 0; $i < $jumlah; $i++) {
                // Generate username unik
                do {
                    $kode = $this->generateKode($request->prefix, $request->kode_kombinasi, $request->panjang_karakter);
                } while (in_array($kode, $usedCodes) || StokVoucher::where('username', $kode)->exists());

                $usedCodes[] = $kode;
                $voucherData = $baseData;
                $voucherData['username'] = $kode;

                // Password
                if ($request->jenis_voucher === 'username_password') {
                    $voucherData['password'] = $kode;
                } else {
                    do {
                        $password = $this->generateKode($request->prefix, $request->kode_kombinasi, $request->panjang_karakter);
                    } while ($password === $kode || in_array($password, $usedCodes));
                    $voucherData['password'] = $password;
                    $usedCodes[] = $password;
                }

                $voucherData['jumlah'] = 1;
                $voucherData['total_komisi'] = $request->komisi;
                $voucherData['total_hpp'] = $request->hpp;

                $voucher = StokVoucher::create($voucherData);
                $createdVouchers[] = $voucher;
            }

            DB::commit();

            $message = "Berhasil membuat {$jumlah} voucher dengan total HPP: " . number_format($totalHpp, 2) .
                    " dan total komisi: " . number_format($totalKomisi, 2);

            return redirect()->route('stokvoucher.index')->with('success', $message);

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->withInput()
                ->with('error', 'Gagal membuat voucher: ' . $e->getMessage());
        }
    }


    private function generateKode($prefix, $kombinasi, $length)
    {
        $length = max(1, $length);
        $random = '';

        // Generate random string character by character untuk lebih random
        for ($i = 0; $i < $length; $i++) {
            $random .= $kombinasi[rand(0, strlen($kombinasi) - 1)];
        }

        return ($prefix ?? '') . $random;
    }

    public function show(StokVoucher $stokVoucher)
    {
        return view('admin-sub.voucher.stok-voucher.show', compact('stokVoucher'));
    }

    public function edit(StokVoucher $stokVoucher)
    {
        $resellers = \App\Models\Reseller::orderBy('nama_lengkap')->get();
        $profiles  = \App\Models\ProfileVoucher::orderBy('nama_profile')->get();

        return view('admin-sub.voucher.stok-voucher.edit', compact('stokVoucher', 'resellers', 'profiles'));
    }

    public function update(Request $request, StokVoucher $stokVoucher)
    {
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

        $updateData = $request->all();
        $updateData['saldo'] = $request->saldo === 'YES' ? true : false;

        // Update total fields untuk voucher individual
        $updateData['total_komisi'] = $request->komisi;
        $updateData['total_hpp'] = $request->hpp;

        $stokVoucher->update($updateData);

        return redirect()->route('stokvoucher.index')->with('success', 'Stok voucher berhasil diperbarui');
    }

    public function destroy(StokVoucher $stokVoucher)
    {
        $stokVoucher->delete();
        return redirect()->route('stokvoucher.index')->with('success', 'Stok voucher berhasil dihapus');
    }

    /**
     * Bulk delete vouchers
     */
    public function bulkDestroy(Request $request)
    {
        $request->validate([
            'voucher_ids' => 'required|array',
            'voucher_ids.*' => 'exists:stok_vouchers,id'
        ]);

        StokVoucher::whereIn('id', $request->voucher_ids)->delete();

        return redirect()->route('stokvoucher.index')
            ->with('success', 'Berhasil menghapus ' . count($request->voucher_ids) . ' voucher');
    }
}
