<?php

namespace App\Http\Controllers;

use App\Models\Subscription;
use Illuminate\Http\Request;
use PDF; // gunakan dompdf (pastikan sudah diinstal: composer require barryvdh/laravel-dompdf)

class InvoiceController extends Controller
{
    public function show($id)
    {
        // Ambil data subscription berdasarkan ID dan relasi user + paket-nya
        // Hanya ditampilkan jika status-nya sudah 'dibayar'
        $subscription = Subscription::with(['user', 'paket'])
            ->where('id', $id)
            ->where('status', 'dibayar') // filter hanya langganan yang sudah dibayar
            ->firstOrFail(); // jika tidak ditemukan, akan tampil error 404 otomatis

        // Siapkan data yang akan dikirim ke view invoice
        $data = [
            // Nomor invoice dengan format INV-00001 (padding 5 digit)
            'invoice_no'      => 'INV-' . str_pad($subscription->id, 5, '0', STR_PAD_LEFT),

            // Nama perusahaan dari tabel subscriptions
            'nama_perusahaan' => $subscription->nama_perusahaan,

            // Nama user dari relasi ke model User
            'nama_user'       => $subscription->user->name,

            // Nomor telepon user
            'telepon'         => $subscription->user->telepon,

            // Nama paket dari relasi paket, ditambah tipe siklus (bulanan/tahunan)
            'nama_paket'      => $subscription->paket?->nama . ' (' . ucfirst($subscription->siklus) . ')',

            // Subdomain pelanggan
            'subdomain_url'   => $subscription->subdomain_url . '.bncradius.id',

            // Harga total diformat jadi rupiah dengan titik pemisah ribuan
            'total_harga'     => number_format($subscription->harga, 0, ',', '.'),

            // Lokasi data center yang dipilih pelanggan
            'data_center'     => $subscription->data_center,

            // Alamat lengkap pelanggan
            'alamat'          => $subscription->alamat,
            'provinsi'        => $subscription->provinsi,
            'kabupaten'       => $subscription->kabupaten,

            // Tanggal terakhir diupdate (biasanya tanggal pembayaran)
            'tanggal'         => $subscription->updated_at->format('d F Y'),
        ];

        // Kirim data ke view 'user.invoice-detail' untuk ditampilkan dalam bentuk HTML
        return view('user.invoice-detail', compact('data'));
    }
}
