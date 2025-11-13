<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Daftar Langganan - BNC Cloud Manager</title>

    <!-- Tailwind -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- jQuery & DataTables -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="{{ asset('css/datatable.css') }}">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

    <style>
        .status-dibayar {
            background-color: #d1fae5;
            color: #065f46;
        }

        .status-belum-dibayar {
            background-color: #fee2e2;
            color: #991b1b;
        }

        .status-aktif {
            background-color: #bfdbfe;
            color: #1e40af;
        }
    </style>
</head>

<body class="bg-gray-50 flex min-h-screen">
    @include('layouts.adminbar')

    <main class="md:pl-72 pt-20 w-full p-6">

        <!-- Header -->
        <div class="flex items-center mb-8">
            <h2 class="text-4xl font-extrabold tracking-tight text-blue-500 flex items-center">
                <i class="fa-solid fa-users w-8 h-8 mr-5 text-blue-500"></i>
                Daftar Semua Langganan Pelanggan
            </h2>
        </div>

        <!-- Kartu Statistik -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8 mb-8">
            <div
                class="bg-white rounded-xl shadow-md p-6 border-l-4 border-green-500 hover:shadow-lg transform hover:-translate-y-1 transition duration-300">
                <div class="flex items-center justify-between mb-3">
                    <h3 class="text-lg font-semibold text-gray-700">Total Pendapatan</h3>
                    <i class="fa-solid fa-money-bill-wave text-green-500 text-2xl"></i>
                </div>
                <p class="text-2xl font-bold text-green-500">
                    Rp {{ number_format($totalIncome ?? 0, 0, ',', '.') }}
                </p>
            </div>

            <div
                class="bg-white rounded-xl shadow-md p-6 border-l-4 border-blue-500 hover:shadow-lg transform hover:-translate-y-1 transition duration-300">
                <div class="flex items-center justify-between mb-3">
                    <h3 class="text-lg font-semibold text-gray-700">Total Langganan</h3>
                    <i class="fa-solid fa-layer-group text-blue-500 text-2xl"></i>
                </div>
                <p class="text-2xl font-bold text-blue-500">{{ $subscriptions->total() }}</p>
            </div>

            <div
                class="bg-white rounded-xl shadow-md p-6 border-l-4 border-yellow-500 hover:shadow-lg transform hover:-translate-y-1 transition duration-300">
                <div class="flex items-center justify-between mb-3">
                    <h3 class="text-lg font-semibold text-gray-700">Menunggu Pembayaran</h3>
                    <i class="fa-solid fa-hourglass-half text-yellow-500 text-2xl"></i>
                </div>
                <p class="text-2xl font-bold text-yellow-500">
                    {{ $subscriptions->where('status', 'belum dibayar')->count() }}
                </p>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-lg border border-blue-200 border-t-4 border-t-blue-400 p-6">
            <div id="loading" class="flex justify-center items-center py-10">
                <div class="w-10 h-10 border-4 border-blue-400 border-t-transparent rounded-full animate-spin">
                </div>
            </div>

            <!-- Tabel -->
            <div id="tableContainer" class="hidden bg-white shadow-lg rounded-2xl p-6 overflow-x-auto">
                <div class="overflow-x-auto">
                    <table id="subscriptionsTable" class="display w-full">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Perusahaan & User</th>
                                <th>Paket & Siklus</th>
                                <th>Subdomain</th>
                                <th>Harga</th>
                                <th>Data Center</th>
                                <th>Status</th>
                                <th>Aksi Cepat</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($subscriptions as $subs)
                                <tr>
                                    <td>{{ ($subscriptions->currentPage() - 1) * $subscriptions->perPage() + $loop->iteration }}
                                    </td>
                                    <td>
                                        <div class="font-semibold text-gray-900">{{ $subs->nama_perusahaan }}</div>
                                        <div class="text-xs text-indigo-600 mt-1">
                                            Pelanggan: {{ $subs->user->name ?? 'User Dihapus' }}
                                        </div>
                                    </td>
                                    <td>{{ $subs->paket->nama ?? 'N/A' }} ({{ ucfirst($subs->siklus) }})</td>
                                    <td><b>{{ $subs->subdomain_url }}</b>.bncradius.id</td>
                                    <td>Rp {{ number_format($subs->harga, 0, ',', '.') }}</td>
                                    <td>{{ $subs->data_center }}</td>
                                    <td>
                                        @php
                                            $status = strtolower($subs->status);
                                            $statusClass = [
                                                'dibayar' => 'status-dibayar',
                                                'belum dibayar' => 'status-belum-dibayar',
                                                'aktif' => 'status-aktif',
                                            ];
                                            $currentClass = $statusClass[$status] ?? 'bg-gray-100 text-gray-700';
                                        @endphp
                                        <span
                                            class="px-3 py-1 inline-flex text-xs font-semibold rounded-full {{ $currentClass }}">
                                            {{ ucfirst($subs->status) }}
                                        </span>
                                    </td>
                                    <td>
                                        @if ($subs->status == 'belum dibayar')
                                            <form action="{{ route('admin.subscription.updateStatus', $subs->id) }}"
                                                method="POST" class="inline-block">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="status" value="dibayar">
                                                <button type="submit"
                                                    class="text-green-600 hover:text-white hover:bg-green-600 border border-green-600 px-3 py-1 text-xs rounded-full transition duration-150 ease-in-out font-semibold">
                                                    <i class="fas fa-check-circle"></i> Bayar
                                                </button>
                                            </form>
                                        @endif
                                        <form action="{{ route('admin.subscription.destroy', $subs->id) }}"
                                            method="POST" class="inline-block"
                                            onsubmit="return confirm('Apakah Anda yakin ingin menghapus langganan ID {{ $subs->id }}?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="text-red-600 hover:text-white hover:bg-red-600 border border-red-600 px-3 py-1 text-xs rounded-full transition duration-150 ease-in-out font-semibold">
                                                <i class="fas fa-trash"></i> Hapus
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>

    <script>
        $(document).ready(function() {
            $('#subscriptionsTable').DataTable({
                responsive: true,
                ordering: false,
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/id.json'
                },
                initComplete: function() {
                    $('#loading').hide();
                    $('#tableContainer').removeClass('hidden').hide().fadeIn(200);
                }
            });
        });
    </script>

</body>

</html>
