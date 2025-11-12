<?php

namespace App\Http\Controllers;

use App\Models\Subscription;
use Illuminate\Http\Request;
use PDF; // gunakan dompdf (pastikan sudah diinstal: composer require barryvdh/laravel-dompdf)

class InvoiceController extends Controller
{
    public function show($id)
    {
        $subscription = Subscription::with(['user', 'paket'])
            ->where('id', $id)
            ->where('status', 'dibayar') // hanya tampil jika sudah dibayar
            ->firstOrFail();

        $data = [
            'invoice_no'      => 'INV-' . str_pad($subscription->id, 5, '0', STR_PAD_LEFT),
            'nama_perusahaan' => $subscription->nama_perusahaan,
            'nama_user'       => $subscription->user->name,
            'telepon'         => $subscription->user->telepon,
            'nama_paket'      => $subscription->paket?->nama . ' (' . ucfirst($subscription->siklus) . ')',
            'subdomain_url'   => $subscription->subdomain_url . '.bncradius.id',
            'total_harga'     => number_format($subscription->harga, 0, ',', '.'),
            'data_center'     => $subscription->data_center,
            'alamat'          => $subscription->alamat,
            'provinsi'        => $subscription->provinsi,
            'kabupaten'       => $subscription->kabupaten,
            'tanggal'         => $subscription->updated_at->format('d F Y'),
        ];

        return view('user.invoice-detail', compact('data'));
    }
}
