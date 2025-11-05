<!DOCTYPE html>
<html>
<head>
    <title>Invoice #{{ $subscription->id }}</title>
    <style>
        body { font-family: Arial, sans-serif; }
        h1 { color: #333; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ccc; padding: 8px; text-align: left; }
    </style>
</head>
<body>
    <h1>Invoice #{{ $subscription->id }}</h1>
    <p>Perusahaan: {{ $subscription->nama_perusahaan }}</p>
    <p>User: {{ $subscription->user->name ?? 'User Dihapus' }}</p>
    <p>Paket: {{ $subscription->paket->nama ?? 'N/A' }} ({{ ucfirst($subscription->siklus) }})</p>
    <p>Subdomain: <b>{{ $subscription->subdomain_url }}</b>.bncradius.id</p>
    <p>Harga: Rp {{ number_format($subscription->harga, 0, ',', '.') }}</p>
    <p>Data Center: {{ $subscription->data_center }}</p>
</body>
</html>
