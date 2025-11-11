<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice #{{ $subscription->id }}</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body { 
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            background: #f8fafc;
            padding: 40px 20px;
            color: #1e293b;
        }
        
        .invoice-container {
            max-width: 850px;
            margin: 0 auto;
            background: #ffffff;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.07);
        }
        
        /* Header */
        .invoice-header {
            padding: 50px 60px 40px;
            border-bottom: 3px solid #3b82f6;
        }
        
        .header-content {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
        }
        
        .company-info {
            flex: 1;
        }
        
        .company-name {
            font-size: 26px;
            font-weight: 700;
            color: #1e293b;
            margin-bottom: 5px;
        }
        
        .company-tagline {
            font-size: 14px;
            color: #64748b;
            margin-bottom: 15px;
        }
        
        .company-details {
            font-size: 13px;
            color: #64748b;
            line-height: 1.6;
        }
        
        .invoice-title-section {
            text-align: right;
        }
        
        .invoice-badge {
            display: inline-block;
            background: #dcfce7;
            color: #166534;
            padding: 8px 20px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 15px;
        }
        
        .invoice-label {
            font-size: 14px;
            color: #64748b;
            margin-bottom: 5px;
        }
        
        .invoice-number {
            font-size: 28px;
            font-weight: 700;
            color: #1e293b;
        }
        
        /* Body Content */
        .invoice-body {
            padding: 50px 60px;
        }
        
        .info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 40px;
            margin-bottom: 50px;
        }
        
        .info-card h3 {
            color: #1e293b;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 15px;
            color: #3b82f6;
        }
        
        .info-item {
            margin-bottom: 12px;
            font-size: 14px;
            color: #475569;
            line-height: 1.6;
        }
        
        .info-item strong {
            color: #1e293b;
            font-weight: 600;
            display: block;
            margin-top: 2px;
        }
        
        .info-label {
            color: #94a3b8;
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        /* Table */
        .items-section {
            margin-top: 40px;
        }
        
        .section-title {
            font-size: 16px;
            font-weight: 600;
            color: #1e293b;
            margin-bottom: 20px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        .items-table {
            width: 100%;
            border-collapse: collapse;
        }
        
        .items-table thead {
            background: #f8fafc;
            border-top: 2px solid #e2e8f0;
            border-bottom: 2px solid #e2e8f0;
        }
        
        .items-table th {
            padding: 16px 20px;
            text-align: left;
            font-size: 12px;
            font-weight: 600;
            color: #64748b;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        .items-table th.text-right {
            text-align: right;
        }
        
        .items-table tbody td {
            padding: 25px 20px;
            border-bottom: 1px solid #f1f5f9;
            font-size: 14px;
            color: #475569;
        }
        
        .items-table td.text-right {
            text-align: right;
        }
        
        .service-name {
            font-weight: 600;
            color: #1e293b;
            font-size: 15px;
            margin-bottom: 8px;
        }
        
        .service-details {
            font-size: 13px;
            color: #64748b;
            line-height: 1.6;
        }
        
        .service-details strong {
            color: #3b82f6;
        }
        
        /* Summary */
        .summary-section {
            margin-top: 30px;
            display: flex;
            justify-content: flex-end;
        }
        
        .summary-box {
            width: 350px;
            background: #f8fafc;
            border-radius: 8px;
            padding: 25px;
        }
        
        .summary-row {
            display: flex;
            justify-content: space-between;
            padding: 12px 0;
            font-size: 14px;
            color: #475569;
        }
        
        .summary-row.total {
            border-top: 2px solid #e2e8f0;
            margin-top: 10px;
            padding-top: 20px;
            font-size: 18px;
            font-weight: 700;
            color: #1e293b;
        }
        
        .summary-row.total .amount {
            color: #3b82f6;
        }
        
        /* Footer Notes */
        .invoice-footer {
            margin-top: 50px;
            padding: 30px;
            background: #f8fafc;
            border-radius: 8px;
        }
        
        .footer-title {
            font-size: 14px;
            font-weight: 600;
            color: #1e293b;
            margin-bottom: 12px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        .footer-content {
            font-size: 13px;
            color: #64748b;
            line-height: 1.8;
        }
        
        .payment-info {
            margin-top: 20px;
            padding: 20px;
            background: #fff;
            border-radius: 6px;
            border-left: 4px solid #3b82f6;
        }
        
        .payment-info strong {
            color: #1e293b;
        }
        
        /* Print Styles */
        @media print {
            body {
                background: #fff;
                padding: 0;
            }
            
            .invoice-container {
                box-shadow: none;
                max-width: 100%;
            }
        }
    </style>
</head>
<body>
    <div class="invoice-container">
        
        <!-- Header -->
        <div class="invoice-header">
            <div class="header-content">
                <div class="company-info">
                    <div class="company-name">PT BORNEO NETWORK CENTER</div>
                    <div class="company-tagline">Network Infrastructure Solutions</div>
                    <div class="company-details">
                        Jl. Panglima Batur Barat No. 39<br>
                        Banjarbaru, Kalimantan Selatan 70714<br>
                        Email: info@bncradius.id | Tel: (0511) 123-4567
                    </div>
                </div>
                <div class="invoice-title-section">
                    <div class="invoice-badge">✓ LUNAS</div>
                    <div class="invoice-label">INVOICE</div>
                    <div class="invoice-number">#{{ $subscription->id }}</div>
                </div>
            </div>
        </div>

        <!-- Body -->
        <div class="invoice-body">
            
            <!-- Info Grid -->
            <div class="info-grid">
                <div class="info-card">
                    <h3>Tagihan Kepada</h3>
                    <div class="info-item">
                        <div class="info-label">Nama Perusahaan</div>
                        <strong>{{ $subscription->nama_perusahaan }}</strong>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Pengguna Utama</div>
                        <strong>{{ $subscription->user->name ?? 'User Dihapus' }}</strong>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Kontak</div>
                        <strong>{{ $subscription->user->telepon ?? '-' }}</strong>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Email</div>
                        <strong>{{ $subscription->user->email ?? '-' }}</strong>
                    </div>
                </div>
                
                <div class="info-card">
                    <h3>Detail Invoice</h3>
                    <div class="info-item">
                        <div class="info-label">Tanggal Invoice</div>
                        <strong>{{ now()->format('d F Y') }}</strong>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Tanggal Pembayaran</div>
                        <strong>{{ now()->format('d F Y') }}</strong>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Metode Pembayaran</div>
                        <strong>Transfer Bank</strong>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Status</div>
                        <strong style="color: #16a34a;">LUNAS</strong>
                    </div>
                </div>
            </div>

            <!-- Items Table -->
            <div class="items-section">
                <div class="section-title">Detail Layanan</div>
                
                <table class="items-table">
                    <thead>
                        <tr>
                            <th style="width: 5%;">#</th>
                            <th>Deskripsi</th>
                            <th style="width: 20%;">Periode</th>
                            <th class="text-right" style="width: 20%;">Harga</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>
                                <div class="service-name">Langganan Paket {{ $subscription->paket->nama ?? 'N/A' }}</div>
                                <div class="service-details">
                                    Subdomain: <strong>{{ $subscription->subdomain_url }}.bncradius.id</strong><br>
                                    Data Center: {{ $subscription->data_center }}<br>
                                    Periode Aktif: {{ \Carbon\Carbon::parse($subscription->tanggal_mulai ?? now())->format('d/m/Y') }} - {{ \Carbon\Carbon::parse($subscription->tanggal_berakhir ?? now()->addMonth())->format('d/m/Y') }}
                                </div>
                            </td>
                            <td>{{ ucfirst($subscription->siklus) }}</td>
                            <td class="text-right"><strong>Rp {{ number_format($subscription->harga, 0, ',', '.') }}</strong></td>
                        </tr>
                    </tbody>
                </table>

                <!-- Summary -->
                <div class="summary-section">
                    <div class="summary-box">
                        <div class="summary-row">
                            <span>Subtotal</span>
                            <span>Rp {{ number_format($subscription->harga, 0, ',', '.') }}</span>
                        </div>
                        <div class="summary-row">
                            <span>PPN (11%)</span>
                            <span>Rp {{ number_format($subscription->harga * 0.11, 0, ',', '.') }}</span>
                        </div>
                        <div class="summary-row total">
                            <span>TOTAL</span>
                            <span class="amount">Rp {{ number_format($subscription->harga * 1.11, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Footer Notes -->
            <div class="invoice-footer">
                <div class="footer-title">Catatan Penting</div>
                <div class="footer-content">
                    Terima kasih atas pembayaran Anda. Invoice ini adalah bukti pembayaran yang sah untuk layanan langganan BNC Radius. Untuk informasi lebih lanjut atau bantuan teknis, silakan hubungi tim support kami.
                </div>
                
                <div class="payment-info">
                    <strong>Informasi Pembayaran:</strong><br>
                    Bank Mandiri - 1234567890<br>
                    a/n PT Borneo Network Center<br>
                    <em>Pembayaran telah dikonfirmasi dan diverifikasi pada {{ now()->format('d F Y, H:i') }} WIB</em>
                </div>
            </div>

        </div>

    </div>
</body>
</html>