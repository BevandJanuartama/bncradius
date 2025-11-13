{{-- resources/views/user/invoice-detail.blade.php --}}
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Lembar Invoice</title>
    <style>
        @page {
            size: A4;
            margin: 0;
        }

        body {
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: #333;
            background-color: #fff;
        }

        /* Kop surat biru full (tanpa putih di atas & bawah) */
        .kop-surat {
            text-align: center;
            background-color: #549BE7;
            color: #fff;
            width: 100%;
            padding: 25px 0;
            margin: 0;
        }
        .kop-surat h1 {
            margin: 0;
            font-size: 28px;
            letter-spacing: 1px;
        }
        .kop-surat h2 {
            margin: 3px 0;
            font-size: 18px;
            font-weight: normal;
        }
        .kop-surat p {
            margin: 2px 0;
            font-size: 12px;
        }

        /* Kontainer isi */
        .content {
            margin: 30px 40px;
        }

        /* Judul Invoice */
        .invoice-title {
            text-align: center;
            font-size: 26px;
            font-weight: bold;
            color: #2667FF;
            margin-bottom: 8px;
        }

        /* Nomor & Tanggal sejajar kiri-kanan di bawah judul */
        .nomor-surat {
            display: flex;
            justify-content: space-between;
            align-items: center; /* sejajarkan vertikal */
            font-size: 14px;
            color: #333;
            margin-bottom: 25px;
            line-height: 1; /* biar tinggi baris sama */
        }

        /* Info pelanggan tanpa border dan ada jarak antar baris */
        .invoice-info {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 25px;
        }
        .invoice-info td {
            border: none;
            padding: 6px 0;
            font-size: 14px;
        }
        .invoice-info .label {
            display: inline-block;
            width: 200px; /* agar titik dua sejajar */
        }
        .invoice-info tr + tr td {
            padding-top: 8px;
        }

        /* Tabel detail paket */
        table.package {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 25px;
            background-color: #fff;
        }
        table.package, .package th, .package td {
            border: 1px solid #555;
        }
        .package th, .package td {
            padding: 10px;
            vertical-align: top;
            font-size: 14px;
        }
        .package th {
            background-color: #2667FF;
            color: #fff;
        }
        /* Rata Kanan untuk kolom Total Harga di tabel detail */
        .package td:last-child {
            text-align: right;
        }

        /* Catatan */
        .note {
            margin-top: 15px;
            font-size: 14px;
            line-height: 1.5;
        }

        /* Footer lebih ke bawah */
        .footer {
            margin-top: 70px;
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

    <div class="kop-surat">
        <h1>PT Borneo Network Center</h1>
        <h2>Billing Mikrotik - PPPoE & Hotspot</h2>
        <p>Jl. Palm Raya, Ruko No. 6, RT 50 RW 07, Kel. Guntung Manggis, Landasan Ulin</p>
        <p>Banjarbaru, Kalimantan Selatan, Indonesia</p>
    </div> 

    <div class="content">

        <div class="invoice-title">INVOICE BUKTI PEMBAYARAN</div>

        <br>
        <br>

        <table class="invoice-info">
            <tr>
                <td><span class="label"><strong>No Invoice</strong></span>: <i>BNC-658-00-07-{{ $subscription->id }}</i></td>
            </tr>
            <tr>
                <td><span class="label"><strong>Nama Perusahaan</strong></span>: {{ $subscription->nama_perusahaan ?? '-' }}</td>
            </tr>
            <tr>
                <td><span class="label"><strong>Nama Pelanggan</strong></span>: {{ $subscription->user->name ?? '-' }}</td>
            </tr>
            <tr>
                <td><span class="label"><strong>No. Telp</strong></span>: {{ $subscription->telepon ?? '-' }}</td>
            </tr>
            <tr>
                <td><span class="label"><strong>Alamat Perusahaan</strong></span>: {{ $subscription->alamat ?? '-' }}</td>
            </tr>
            <tr>
                <td><span class="label"><strong>Kabupaten/Kota</strong></span>: {{ $subscription->kabupaten ?? '-' }}</td>
            </tr>
            <tr>
                <td><span class="label"><strong>Provinsi</strong></span>: {{ $subscription->provinsi ?? '-' }}</td>
            </tr>
            <tr>
                <td><span class="label"><strong>Tanggal Pembuatan</strong></span>: {{ $subscription->created_at->format('d M Y') }}</td>
            </tr>
        </table>

        <br>
        <br>

        <table class="package">
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

        <br>
        
        <p class="note">
            Terima kasih telah melakukan pembayaran dan berlangganan layanan kami. 
            Silakan simpan lembar invoice ini sebagai bukti pembayaran yang sah.
        </p>

        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>

        <div class="footer">
            <p><strong>BNC Network Center</strong></p>
            <p>&copy; {{ date('Y') }} All Rights Reserved</p>
        </div>
    </div>

</body>
</html>