<?php

namespace App\Http\Controllers;

use App\Models\Subscription;
use App\Models\Invoice;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class AdminSubscriptionController extends Controller
{
    /**
     * Menampilkan semua data subscription (halaman dashboard admin)
     */
    public function index()
    {
        $subscriptions = Subscription::with('paket', 'user')
                                    ->orderBy('id', 'asc')
                                    ->paginate(10);

        $totalIncome = Subscription::where('status', 'dibayar')->sum('harga');

        return view('admin.dashboard', compact('subscriptions', 'totalIncome'));
    }

    /**
     * Mengupdate status subscription
     * Jika status menjadi "dibayar", generate PDF invoice otomatis
     */
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:belum dibayar,dibayar',
        ]);

        $subscription = Subscription::findOrFail($id);
        $subscription->status = $request->status;
        $subscription->save();

        // Generate PDF jika status berubah menjadi "dibayar"
        if ($request->status === 'dibayar') {

            // Load template invoice
            $pdf = Pdf::loadView('admin.invoice', [
                'subscription' => $subscription
            ]);

            // Nama file dan path
            $filename = 'invoice_'.$subscription->id.'.pdf';
            $path = storage_path('app/public/invoices/'.$filename);

            // Simpan PDF ke storage
            $pdf->save($path);

            // Simpan record ke table invoices (cek dulu agar tidak duplikat)
            Invoice::updateOrCreate(
                ['subscription_id' => $subscription->id],
                ['file_path' => 'invoices/'.$filename]
            );
        }

        return redirect()->back()->with('success', 'Status langganan berhasil diperbarui.');
    }

    /**
     * Menghapus data subscription beserta invoice terkait
     */
    public function destroy($id)
    {
        $subscription = Subscription::findOrFail($id);

        // Hapus invoice terkait jika ada
        $invoice = Invoice::where('subscription_id', $subscription->id)->first();
        if ($invoice) {
            $invoicePath = storage_path('app/public/'.$invoice->file_path);
            if (file_exists($invoicePath)) {
                unlink($invoicePath); // hapus file PDF
            }
            $invoice->delete(); // hapus record
        }

        $subscription->delete();

        return redirect()->back()->with('success', 'Data langganan berhasil dihapus.');
    }
}
