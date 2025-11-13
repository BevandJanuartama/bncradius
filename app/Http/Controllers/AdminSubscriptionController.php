<?php

namespace App\Http\Controllers;

use App\Models\Subscription;
use App\Models\Invoice;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

/**
 * Controller: AdminSubscriptionController
 *
 * Controller ini digunakan oleh admin untuk mengelola data langganan (subscription).
 * Fitur yang tersedia:
 * - Menampilkan daftar subscription
 * - Mengubah status langganan (dan otomatis membuat invoice PDF jika dibayar)
 * - Menghapus subscription beserta invoice-nya
 */
class AdminSubscriptionController extends Controller
{
    /**
     * Menampilkan daftar semua subscription di halaman dashboard admin.
     *
     * Mengambil data dari tabel subscriptions beserta relasi paket dan user.
     * Juga menghitung total pendapatan dari subscription yang sudah dibayar.
     */
    public function index()
    {
        $subscriptions = Subscription::with('paket', 'user') // relasi paket & user
                                    ->orderBy('id', 'asc')
                                    ->paginate(10);          // pagination 10 item per halaman

        $totalIncome = Subscription::where('status', 'dibayar')->sum('harga'); // total pendapatan

        return view('admin.dashboard', compact('subscriptions', 'totalIncome'));
    }

    /**
     * Mengubah status langganan (subscription).
     *
     * Jika status diubah menjadi "dibayar", maka sistem otomatis:
     * - Membuat file PDF invoice
     * - Menyimpan file ke folder `storage/app/public/invoices`
     * - Menyimpan atau memperbarui data invoice di tabel `invoices`
     */
    public function updateStatus(Request $request, $id)
    {
        // Validasi input status agar hanya boleh "dibayar" atau "belum dibayar"
        $request->validate([
            'status' => 'required|in:belum dibayar,dibayar',
        ]);

        // Ambil data subscription berdasarkan ID
        $subscription = Subscription::findOrFail($id);
        $subscription->status = $request->status;
        $subscription->save();

        // Jika status berubah menjadi "dibayar", buat PDF invoice
        if ($request->status === 'dibayar') {

            // Load tampilan invoice (view: admin.invoice)
            $pdf = Pdf::loadView('admin.invoice', [
                'subscription' => $subscription
            ]);

            // Tentukan nama file dan path penyimpanan
            $filename = 'invoice_'.$subscription->id.'.pdf';
            $path = storage_path('app/public/invoices/'.$filename);

            // Simpan file PDF ke storage publik
            $pdf->save($path);

            // Simpan ke tabel invoices (jika sudah ada, update saja)
            Invoice::updateOrCreate(
                ['subscription_id' => $subscription->id],
                ['file_path' => 'invoices/'.$filename]
            );
        }

        return redirect()->back()->with('success', 'Status langganan berhasil diperbarui.');
    }

    /**
     * Menghapus data langganan (subscription) beserta file dan record invoice-nya.
     *
     * - Menghapus file PDF dari storage jika ada.
     * - Menghapus record invoice dan subscription di database.
     */
    public function destroy($id)
    {
        $subscription = Subscription::findOrFail($id);

        // Cek dan hapus invoice terkait jika ada
        $invoice = Invoice::where('subscription_id', $subscription->id)->first();
        if ($invoice) {
            $invoicePath = storage_path('app/public/'.$invoice->file_path);

            if (file_exists($invoicePath)) {
                unlink($invoicePath); // Hapus file PDF dari storage
            }

            $invoice->delete(); // Hapus record invoice dari database
        }

        // Hapus data subscription utama
        $subscription->delete();

        return redirect()->back()->with('success', 'Data langganan berhasil dihapus.');
    }
}
