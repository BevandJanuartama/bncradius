<?php

namespace App\Http\Controllers;

use App\Models\Subscription;
use App\Models\Paket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SubscriptionController extends Controller
{
    /**
     * Tampilkan form berlangganan
     */
    public function create(Request $request)
    {
        $pakets = Paket::all();
        $selectedPaketId = $request->paket_id; // bisa dari query string

        return view('user.subs-form', [
            'pakets' => $pakets,
            'selectedPaketId' => $selectedPaketId,
        ]);
    }

    /**
     * Simpan subscription baru
     */
    public function store(Request $request)
{
    try {
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

        $subscription = Subscription::create([
            'user_id'         => Auth::id(),
            'paket_id'        => $request->paket_id,
            'data_center'     => $request->data_center,
            'subdomain_url'   => $request->subdomain_url,
            'siklus'          => $request->siklus,
            'harga'           => $request->harga,
            'nama_perusahaan' => $request->nama_perusahaan,
            'provinsi'        => $request->provinsi,
            'kabupaten'       => $request->kabupaten,
            'alamat'          => $request->alamat,
            'telepon'         => Auth::user()->telepon,
            'setuju'          => true,
            'status'          => 'belum dibayar',
        ]);

        return response()->json([
            'success' => true,
            'subscription' => $subscription
        ]);
    } catch (\Illuminate\Validation\ValidationException $e) {
        return response()->json([
            'success' => false,
            'errors' => $e->errors()
        ], 422);
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => $e->getMessage()
        ], 500);
    }
}


    /**
     * Tampilkan daftar subscription user
     */
    public function index()
    {
        $subscriptions = Subscription::with('paket')
                            ->where('user_id', Auth::id())
                            ->latest()
                            ->get();

        return view('user.subs-index', compact('subscriptions'));
    }

    /**
     * Tampilkan detail subscription
     */
    public function show($id)
    {
        $subscription = Subscription::with('paket')->findOrFail($id);

        // Pastikan subscription milik user
        if ($subscription->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        return view('user.subs-show', compact('subscription'));
    }

    public function indexJson() {
        $subs = \App\Models\Subscription::all(); // bisa tambah with('paket') jika perlu
        return response()->json($subs);
    }

    public function userSubscriptionsJson() {
        $subs = Subscription::with('paket', 'invoice')
                    ->where('user_id', auth()->id())
                    ->get();

        $data = $subs->map(function($sub) {
            return [
                'id' => $sub->id,
                'nama_perusahaan' => $sub->nama_perusahaan,
                'data_center' => $sub->data_center,
                'subdomain_url' => $sub->subdomain_url,
                'siklus' => $sub->siklus,
                'harga' => $sub->harga,
                'status' => $sub->status,
                'nama_paket' => $sub->paket?->nama,
                'invoice' => $sub->invoice ? ['file_path' => $sub->invoice->file_path] : null,
                'created_at' => $sub->created_at,
            ];
        });

        return response()->json($data);
    }

}
