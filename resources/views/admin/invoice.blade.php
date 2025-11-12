{{-- resources/views/user/invoice-detail.blade.php --}}
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Lembar Invoice</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: #333;
            margin: 40px;
            background-color: #f7f9fc;
        }
        /* Kop surat */
        .kop-surat {
            text-align: center;
            padding: 20px;
            background-color: #549BE7;
            color: #fff;
            border-radius: 8px;
            margin-bottom: 30px;
        }
        .kop-surat img {
            width: 80px;
            margin-bottom: 10px;
        }
        .kop-surat h1 {
            margin: 5px 0;
            font-size: 28px;
        }
        .kop-surat h2 {
            margin: 5px 0;
            font-size: 18px;
            font-weight: normal;
        }
        .kop-surat p {
            margin: 2px 0;
            font-size: 12px;
        }

        /* Judul Invoice */
        .invoice-title {
            text-align: center;
            margin: 20px 0;
            font-size: 26px;
            font-weight: bold;
            color: #2667FF;
        }

        /* Info Pelanggan */
        .invoice-info, .billing-info {
            width: 100%;
            margin-bottom: 25px;
        }
        .invoice-info td, .billing-info td {
            padding: 6px 10px;
            vertical-align: top;
        }
        .invoice-info td strong {
            color: #2667FF;
        }

        /* Table billing */
        .billing-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 25px;
            box-shadow: 0 0 10px rgba(0,0,0,0.05);
            background-color: #fff;
            border-radius: 8px;
            overflow: hidden;
        }
        .billing-table th, .billing-table td {
            padding: 12px 15px;
            text-align: left;
        }
        .billing-table th {
            background-color: #2667FF;
            color: #fff;
            font-weight: 600;
        }
        .billing-table tr:nth-child(even) {
            background-color: #f2f8ff;
        }

        /* Footer */
        .footer {
            margin-top: 40px;
            text-align: center;
            font-size: 12px;
            color: #555;
        }
        .footer strong {
            color: #2667FF;
        }
    </style>
</head>
<body>

    <!-- Kop Surat -->
    <div class="kop-surat">
        <h1>Borneo Network Center</h1>
        <h2>Billing Mikrotik - PPPoE & Hotspot</h2>
        <p>Jl. Palm Raya, Ruko No. 6, RT 50 RW 07, Kel. Guntung Manggis, Landasan Ulin</p>
        <p>Banjarbaru, Kalimantan Selatan, Indonesia</p>
    </div>

    <!-- Judul Invoice -->
    <div class="invoice-title">INVOICE PEMBAYARAN</div>

    <!-- Info Pelanggan & Perusahaan -->
    <table class="invoice-info">
        <tr>
            <td><strong>Nama Perusahaan:</strong> {{ $subscription->nama_perusahaan ?? '-' }}</td>
            <td><strong>Nama Pelanggan:</strong> {{ $subscription->user->name ?? '-' }}</td>
        </tr>
        <tr>
            <td><strong>No. Telepon:</strong> {{ $subscription->telepon ?? '-' }}</td>
            <td><strong>Alamat:</strong> {{ $subscription->alamat ?? '-' }}</td>
        </tr>
        <tr>
            <td><strong>Kabupaten:</strong> {{ $subscription->kabupaten ?? '-' }}</td>
            <td><strong>Provinsi:</strong> {{ $subscription->provinsi ?? '-' }}</td>
        </tr>
    </table>

    <!-- Detail Paket -->
    <table class="billing-table">
        <thead>
            <tr>
                <th>Nama Paket</th>
                <th>Siklus</th>
                <th>Subdomain</th>
                <th>Data Center</th>
                <th>Total Harga</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>{{ $subscription->paket->nama ?? '-' }}</td>
                <td>{{ ucfirst($subscription->siklus ?? '-') }}</td>
                <td>{{ $subscription->subdomain_url ?? '-' }}.bncradius.id</td>
                <td>{{ $subscription->data_center ?? '-' }}</td>
                <td>Rp {{ number_format($subscription->harga, 0, ',', '.') }}</td>
            </tr>
        </tbody>
    </table>

    <!-- Status & Tanggal -->
    <table class="invoice-info">
        <tr>
            <td><strong>Tanggal Transaksi:</strong> {{ $subscription->created_at->format('d M Y') }}</td>
            <td><strong>Status Pembayaran:</strong> {{ ucfirst($subscription->status ?? '-') }}</td>
        </tr>
    </table>

    <!-- Catatan -->
    <p>Terima kasih telah melakukan pembayaran dan berlangganan layanan kami. Silakan simpan lembar invoice ini sebagai bukti pembayaran yang sah.</p>

    <!-- Footer -->
    <div class="footer">
        <p><strong>BNC Network Center</strong></p>
        <p>&copy; {{ date('Y') }} All Rights Reserved</p>
    </div>

</body>
</html>
