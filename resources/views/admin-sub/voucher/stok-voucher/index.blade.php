<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Daftar Stok Voucher - BNC Cloud Manager</title>

    <!-- Tailwind -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- jQuery & DataTables -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="{{ asset('css/datatable.css') }}">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

</head>

<body class="bg-gray-50 flex min-h-screen">

    <!-- Sidebar -->
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

        <!-- HEADER -->
        <div class="flex items-center mb-8">
            <h2
                class="text-4xl font-extrabold tracking-tight text-blue-500 flex items-center">
                <i class="fa-solid fa-database w-8 h-8 mr-5 text-blue-500"></i>
                Daftar Stok Voucher
            </h2>
        </div>

        <!-- KARTU STATISTIK -->
        @php
            $stok = $jumlahStok ?? 0;
            $komisi = $totalKomisi ?? 0;
            $nilaiJual = $totalNilaiJual ?? 0;
            $maxStatistik = max($stok, $komisi, $nilaiJual);
            $denominator = $maxStatistik > 0 ? $maxStatistik : 1;
        @endphp

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8 mb-8">

            <!-- Card 1 -->
            <div
                class="bg-white rounded-xl shadow-md p-6 border-l-4 border-green-500 hover:shadow-lg transform hover:-translate-y-1 transition duration-300">
                <div class="flex items-center justify-between mb-3">
                    <h3 class="text-lg font-semibold text-gray-700">Jumlah Stok</h3>
                    <i class="fa-solid fa-box text-green-500 text-2xl"></i>
                </div>
                <p class="text-2xl font-bold text-green-500">{{ number_format($stok, 0, ',', '.') }}</p>
                <div class="w-full bg-gray-200 rounded-full h-2 mt-3">
                    <div class="bg-green-500 h-2 rounded-full transition-all duration-500"
                        style="width: {{ $stok > 0 ? min(100, ($stok / $denominator) * 100) : 0 }}%"></div>
                </div>
            </div>

            <!-- Card 2 -->
            <div
                class="bg-white rounded-xl shadow-md p-6 border-l-4 border-red-500 hover:shadow-lg transform hover:-translate-y-1 transition duration-300">
                <div class="flex items-center justify-between mb-3">
                    <h3 class="text-lg font-semibold text-gray-700">Total Komisi Mitra</h3>
                    <i class="fa-solid fa-circle-up text-red-500 text-2xl"></i>
                </div>
                <p class="text-2xl font-bold text-red-500">{{ number_format($komisi, 0, ',', '.') }}</p>
                <div class="w-full bg-gray-200 rounded-full h-2 mt-3">
                    <div class="bg-red-500 h-2 rounded-full transition-all duration-500"
                        style="width: {{ $komisi > 0 ? min(100, ($komisi / $denominator) * 100) : 0 }}%"></div>
                </div>
            </div>

            <!-- Card 3 -->
            <div
                class="bg-white rounded-xl shadow-md p-6 border-l-4 border-blue-500 hover:shadow-lg transform hover:-translate-y-1 transition duration-300">
                <div class="flex items-center justify-between mb-3">
                    <h3 class="text-lg font-semibold text-gray-700">Total Nilai Jual</h3>
                    <i class="fa-solid fa-wallet text-blue-500 text-2xl"></i>
                </div>
                <p class="text-2xl font-bold text-blue-500">{{ number_format($nilaiJual, 0, ',', '.') }}</p>
                <div class="w-full bg-gray-200 rounded-full h-2 mt-3">
                    <div class="bg-blue-500 h-2 rounded-full transition-all duration-500"
                        style="width: {{ $nilaiJual > 0 ? min(100, ($nilaiJual / $denominator) * 100) : 0 }}%"></div>
                </div>
            </div>
        </div>

        <!-- CARD TABEL -->
            <div class="bg-white rounded-2xl shadow-lg border border-blue-200 border-t-4 border-t-blue-400 p-6">

                <!-- Tombol Tambah -->
                <div class="mb-6 flex gap-3">
                    <a href="{{ route('stokvoucher.create') }}"
                        class="flex items-center gap-2 bg-emerald-500 text-white px-4 py-2 rounded-md font-medium shadow-md hover:bg-emerald-600 transition duration-500">
                        <i class="fa-solid fa-circle-plus"></i> Tambah Voucher
                    </a>
                </div>


                <div id="loading" class="flex justify-center items-center py-10">
                    <div class="w-10 h-10 border-4 border-blue-400 border-t-transparent rounded-full animate-spin">
                    </div>
                </div>

                <!-- TABEL -->
                <div id="tableContainer" class="hidden bg-white shadow-lg rounded-2xl p-6 overflow-x-auto">
                    <table id="stokVouchers" class="display w-full">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>USERNAME</th>
                                <th>PASSWORD</th>
                                <th>PROFILE</th>
                                <th>ROUTER</th>
                                <th>SERVER</th>
                                <th>MITRA</th>
                                <th>OUTLET</th>
                                <th>HPP</th>
                                <th>KOMISI</th>
                                <th>HJK</th>
                                <th>SALDO</th>
                                <th>ADMIN</th>
                                <th>KODE</th>
                                <th>TGL PEMBUATAN</th>
                                <th>MAC</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($stokVouchers as $voucher)
                                <tr>
                                    <td>{{ $voucher->id }}</td>
                                    <td>{{ $voucher->username }}</td>
                                    <td>{{ $voucher->password }}</td>
                                    <td>{{ $voucher->profileVoucher->nama_profile ?? '-' }}</td>
                                    <td>{{ $voucher->router }}</td>
                                    <td>{{ $voucher->server }}</td>
                                    <td>{{ $voucher->reseller->nama_lengkap ?? '-' }}</td>
                                    <td>{{ $voucher->outlet }}</td>
                                    <td>{{ number_format($voucher->hpp, 0, ',', '.') }}</td>
                                    <td>{{ number_format($voucher->komisi, 0, ',', '.') }}</td>
                                    <td>{{ number_format($voucher->hjk, 0, ',', '.') }}</td>
                                    <td>{{ number_format($voucher->saldo, 0, ',', '.') }}</td>
                                    <td>{{ $voucher->admin }}</td>
                                    <td>{{ $voucher->kode }}</td>
                                    <td>{{ $voucher->tgl_pembuatan }}</td>
                                    <td>
                                        @if ($voucher->mac)
                                            <i class="fa-solid fa-lock-open text-green-600" title="Aktif"></i>
                                        @else
                                            <i class="fa-solid fa-lock text-red-600" title="Tidak Aktif"></i>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
    </main>

    <script>
        $(document).ready(function() {
            $('#stokVouchers').DataTable({
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
