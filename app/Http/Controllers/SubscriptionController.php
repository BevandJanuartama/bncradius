<?php

namespace App\Http\Controllers;

use App\Models\Subscription;
use App\Models\Paket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SubscriptionController extends Controller
{
    /**
     * Tampilkan form pendaftaran langganan (subscription form)
     * 
     * Method ini akan menampilkan semua paket yang tersedia
     * dan juga bisa menangkap `paket_id` dari query string jika user memilih langsung dari daftar paket.
     */
    public function create(Request $request)
    {
        // Ambil semua data paket dari database
        $pakets = Paket::all();

        // Ambil paket yang dipilih dari query string (opsional)
        $selectedPaketId = $request->paket_id;

        // Kirim data ke view form langganan
        return view('user.subs-form', [
            'pakets' => $pakets,
            'selectedPaketId' => $selectedPaketId,
        ]);
    }

    /**
     * Simpan data subscription baru ke database.
     * 
     * Validasi dilakukan untuk memastikan input user sesuai aturan:
     * - Paket harus ada di tabel `pakets`
     * - URL subdomain unik
     * - User wajib menyetujui syarat (checkbox "setuju")
     * 
     * Jika berhasil, data disimpan dan dikembalikan dalam bentuk JSON.
     * Jika gagal validasi atau error server, kembalikan error JSON.
     */
    public function store(Request $request)
    {
        try {
            // Validasi input
            $request->validate([
                'paket_id'        => 'required|exists:pakets,id',
                'data_center'     => 'required|in:IDC 3D JAKARTA,NCIX PEKANBARU',
                'subdomain_url'   => 'required|unique:subscriptions,subdomain_url',
                'siklus'          => 'required|in:bulanan,tahunan',
                'harga'           => 'required|numeric',
                'nama_perusahaan' => 'required|string|max:255',
                'provinsi'        => 'required|string|max:100',
                'kabupaten'       => 'required|string|max:100',
                'alamat'          => 'required|string',
                'setuju'          => 'accepted',
            ]);

            // Simpan data subscription ke database
            $subscription = Subscription::create([
                'user_id'         => Auth::id(),                      // ID user yang login
                'paket_id'        => $request->paket_id,              // ID paket yang dipilih
                'data_center'     => $request->data_center,           // Lokasi data center
                'subdomain_url'   => $request->subdomain_url,         // Subdomain unik
                'siklus'          => $request->siklus,                // Siklus langganan (bulanan/tahunan)
                'harga'           => $request->harga,                 // Harga paket
                'nama_perusahaan' => $request->nama_perusahaan,       // Nama perusahaan pelanggan
                'provinsi'        => $request->provinsi,              // Provinsi pelanggan
                'kabupaten'       => $request->kabupaten,             // Kabupaten pelanggan
                'alamat'          => $request->alamat,                // Alamat lengkap
                'telepon'         => Auth::user()->telepon,           // Ambil dari profil user
                'setuju'          => true,                            // Checkbox "setuju" sudah dikonfirmasi
                'status'          => 'belum dibayar',                 // Status awal
            ]);

            // Jika berhasil, kembalikan JSON sukses
            return response()->json([
                'success' => true,
                'subscription' => $subscription
            ]);
        } 
        // Jika validasi gagal
        catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'errors' => $e->errors()
            ], 422);
        } 
        // Jika error lain
        catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Tampilkan daftar semua subscription milik user yang sedang login.
     * 
     * Data subscription akan dimuat bersama relasi ke tabel `paket`.
     */
    public function index()
    {
        // Ambil semua subscription milik user login dengan relasi paket
        $subscriptions = Subscription::with('paket')
                            ->where('user_id', Auth::id())
                            ->latest() // urutkan dari terbaru
                            ->get();

        // Kirim data ke view daftar subscription user
        return view('user.subs-index', compact('subscriptions'));
    }

    /**
     * Tampilkan detail subscription tertentu.
     * 
     * Pastikan subscription tersebut memang milik user yang sedang login.
     */
    public function show($id)
    {
        // Ambil subscription beserta data paketnya
        $subscription = Subscription::with('paket')->findOrFail($id);

        // Cegah akses jika bukan milik user login
        if ($subscription->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        // Kirim data ke halaman detail
        return view('user.subs-show', compact('subscription'));
    }

    /**
     * Endpoint JSON sederhana untuk menampilkan semua subscription (tanpa filter user).
     * 
     * Bisa digunakan untuk kebutuhan admin atau testing API.
     */
    public function indexJson() {
        $subs = \App\Models\Subscription::all(); // Bisa ditambah with('paket') jika perlu
        return response()->json($subs);
    }

    /**
     * Endpoint JSON khusus user login, dengan relasi ke paket dan invoice.
     * 
     * Data dikembalikan dalam format array yang lebih rapi untuk konsumsi frontend.
     */
    public function userSubscriptionsJson() {
        // Ambil semua subscription user login dengan relasi paket & invoice
        $subs = Subscription::with('paket', 'invoice')
                    ->where('user_id', auth()->id())
                    ->get();

        // Format ulang data agar lebih mudah dipakai di frontend
        $data = $subs->map(function($sub) {
            return [
                'id'                => $sub->id,
                'nama_perusahaan'   => $sub->nama_perusahaan,
                'nama_pelanggan'    => $sub->user?->name,                     // Relasi ke tabel users (jika ada)
                'telepon'           => $sub->telepon,
                'nama_paket'        => $sub->paket?->nama,
                'siklus'            => ucfirst($sub->siklus),
                'subdomain_url'     => $sub->subdomain_url,
                'harga'             => $sub->harga,
                'data_center'       => $sub->data_center,
                'alamat'            => $sub->alamat,
                'provinsi'          => $sub->provinsi,
                'kabupaten'         => $sub->kabupaten,
                'tanggal_transaksi' => $sub->created_at->format('Y-m-d'),
                'status'            => $sub->status,
                'invoice'           => $sub->invoice 
                                        ? ['file_path' => $sub->invoice->file_path] // relasi ke invoice jika ada
                                        : null,
                'created_at'        => $sub->created_at,
                'updated_at'        => $sub->updated_at,
            ];
        });

        // Kembalikan data dalam format JSON
        return response()->json($data);
    }
}
