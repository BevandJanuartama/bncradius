<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Dashboard - BNC CLOUD MANAGER</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="{{ asset('css/datatable.css') }}">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>


</head>

<body class="bg-gray-50 flex min-h-screen">

    {{-- Sidebar sesuai level user --}}
    @if (Auth::user()->level === 'administrator')
        @include('layouts.subadminbar')
    @elseif(Auth::user()->level === 'keuangan')
        @include('layouts.keuanganbar')
    @elseif(Auth::user()->level === 'operator')
        @include('layouts.operatorbar')
    @elseif(Auth::user()->level === 'teknisi')
        @include('layouts.teknisibar')
    @endif

    <main class="md:pl-72 pt-20 w-full p-6">
        {{-- Header --}}
        <div class="flex items-center mb-8">
            <h2 class="text-4xl font-extrabold tracking-tight text-blue-500 flex items-center">
                <i class="fa-solid fa-gauge-high w-8 h-8 mr-4 text-blue-500"></i>Dashboard
            </h2>
        </div>

        {{-- Ringkasan Hari Ini --}}
        <section class="py-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                {{-- Pemasukan Hari Ini --}}
                <div
                    class="bg-white rounded-xl p-6 shadow border-l-4 border-green-500 hover:shadow-lg transform hover:-translate-y-1 transition duration-300">
                    <h3 class="text-lg font-semibold text-gray-600">Pemasukan Hari Ini</h3>
                    <p class="text-3xl font-bold text-green-500 mt-2">
                        Rp{{ number_format($pemasukanHariIni ?? 0, 0, ',', '.') }}
                    </p>
                    <p class="text-sm text-gray-500 mt-1">Total pemasukan tanggal
                        {{ \Carbon\Carbon::now('Asia/Jakarta')->translatedFormat('d F Y') }}</p>
                </div>

                {{-- Pengeluaran Hari Ini --}}
                <div
                    class="bg-white rounded-xl p-6 shadow border-l-4 border-red-500 hover:shadow-lg transform hover:-translate-y-1 transition duration-300">
                    <h3 class="text-lg font-semibold text-gray-600">Pengeluaran Hari Ini</h3>
                    <p class="text-3xl font-bold text-red-500 mt-2">
                        Rp{{ number_format($pengeluaranHariIni ?? 0, 0, ',', '.') }}
                    </p>
                    <p class="text-sm text-gray-500 mt-1">Total pengeluaran tanggal
                        {{ \Carbon\Carbon::now('Asia/Jakarta')->translatedFormat('d F Y') }}</p>
                </div>
            </div>
        </section>

        {{-- Info Log --}}
        <section class="py-8">
            <h3 class="text-xl font-bold text-gray-700 mb-4 flex items-center">
                <i class="fa-solid fa-clipboard-list mr-2 text-blue-400"></i> Info Log
            </h3>

            <div class="bg-white rounded-2xl shadow-lg border border-blue-200 border-t-4 border-t-blue-400 p-6">
                <div id="loading" class="flex justify-center items-center py-10">
                    <div class="w-10 h-10 border-4 border-blue-400 border-t-transparent rounded-full animate-spin">
                    </div>
                </div>
                <div id="tableContainer" class="bg-white shadow-lg rounded-2xl p-6 overflow-x-auto hidden">
                    <table id="logTable" class="display w-full">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Lengkap</th>
                                <th>Telepon</th>
                                <th>IP Address</th>
                                <th>Info Aktivitas</th>
                                <th>Tanggal Kejadian</th>
                                <th>Level</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($infos as $info)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $info->nama_lengkap }}</td>
                                    <td>{{ $info->telepon }}</td>
                                    <td>{{ $info->ip_address }}</td>
                                    <td>{{ $info->info_aktifitas }}</td>
                                    <td>{{ $info->tanggal_kejadian }}</td>
                                    <td>{{ $info->level }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </section>

        {{-- Grafik Bulanan --}}
        <section class="py-8">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <div class="bg-white rounded-xl shadow p-6 lg:col-span-2">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-semibold text-gray-700 flex items-center">
                            <i class="fa-solid fa-chart-line mr-2 text-blue-600"></i>Grafik Pemasukan Bulanan
                        </h3>
                    </div>
                    <canvas id="pemasukanChart" height="120"></canvas>
                </div>

                <div class="bg-white rounded-xl shadow p-6 text-gray-700">
                    <div class="flex items-center mb-4">
                        <i class="fa-solid fa-calendar-days mr-2 text-blue-600"></i>
                        <h3 class="text-lg font-semibold">Transaksi Bulan Ini</h3>
                    </div>

                    <div class="space-y-6">
                        <div>
                            <p class="text-3xl font-bold text-green-500">
                                Rp{{ number_format($pemasukanBulanIni ?? 0, 0, ',', '.') }}
                            </p>
                            <p class="text-sm text-gray-500 mt-1">Total pemasukan bulan ini</p>
                            <hr class="border-gray-300 mt-2" />
                        </div>
                        <div>
                            <p class="text-3xl font-bold text-red-500">
                                Rp{{ number_format($pengeluaranBulanIni ?? 0, 0, ',', '.') }}
                            </p>
                            <p class="text-sm text-gray-500 mt-1">Total pengeluaran bulan ini</p>
                            <hr class="border-gray-300 mt-2" />
                        </div>
                        <div>
                            <p class="text-3xl font-bold text-blue-500">
                                Rp{{ number_format($pendapatanBulanIni ?? 0, 0, ',', '.') }}
                            </p>
                            <p class="text-sm text-gray-500 mt-1">Total pendapatan bulan ini</p>
                            <hr class="border-gray-300 mt-2" />
                        </div>
                    </div>
                </div>
            </div>
        </section>

    </main>

    {{-- Script --}}
    <script>
        $(document).ready(function() {
            $('#logTable').DataTable({
                paging: false,
                searching: false,
                info: false,
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

        const grafikData = @json($grafik ?? []);
        const labels = grafikData.map(x => ("0" + x.hari).slice(-2));
        const dataVals = grafikData.map(x => x.total);

        const ctx = document.getElementById('pemasukanChart').getContext('2d');
        const gradientBlue = ctx.createLinearGradient(0, 0, 0, 300);
        gradientBlue.addColorStop(0, 'rgba(59,130,246,0.6)');
        gradientBlue.addColorStop(1, 'rgba(59,130,246,0)');

        new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Pemasukan',
                    data: dataVals,
                    borderColor: '#3B82F6',
                    backgroundColor: gradientBlue,
                    borderWidth: 2,
                    pointRadius: 4,
                    fill: true,
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: val => 'Rp' + Number(val).toLocaleString('id-ID')
                        }
                    }
                }
            }
        });
    </script>
</body>

</html>
