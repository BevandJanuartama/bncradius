<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Profile Voucher - BNC Cloud Manager</title>

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

    <!-- Sidebar sesuai role -->
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

        <!-- Header -->
        <div class="flex items-center mb-8">
            <h2
                class="text-4xl font-extrabold tracking-tight text-blue-500 flex items-center">
                <i class="fa-solid fa-ticket w-8 h-8 mr-5 text-blue-500"></i>
                Profile Voucher
            </h2>
        </div>
        <!-- Card -->
            <div class="bg-white rounded-2xl shadow-lg border border-blue-200 border-t-4 border-t-blue-400 p-6">

                <!-- Tombol Tambah -->
                <div class="mb-6 flex gap-3">
                    <a href="{{ route('voucher.create') }}" class="flex items-center gap-2 bg-emerald-500 text-white px-4 py-2 rounded-md font-medium shadow-md hover:bg-emerald-600 transition duration-500">
                        <i class="fa-solid fa-circle-plus"></i> Tambah Profile
                    </a>
                </div>

                <div id="loading" class="flex justify-center items-center py-10">
                    <div class="w-10 h-10 border-4 border-blue-400 border-t-transparent rounded-full animate-spin">
                    </div>
                </div>

                <!-- Tabel -->
                <div id="tableContainer" class="hidden bg-white shadow-lg rounded-2xl p-6 overflow-x-auto">
                    <table id="voucherTable" class="display w-full">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>NAMA PROFILE</th>
                                <th>GROUP</th>
                                <th>ADDR LIST</th>
                                <th>RATE LIMIT</th>
                                <th>SHARED</th>
                                <th>KUOTA</th>
                                <th>DURASI</th>
                                <th>AKTIF</th>
                                <th>HPP</th>
                                <th>KOMISI</th>
                                <th>HJK</th>
                                <th>AKSI</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($vouchers as $v)
                                <tr>
                                    <td>{{ $v->id }}</td>
                                    <td>{{ $v->nama_profile }}</td>
                                    <td>{{ $v->mikrotik_group }}</td>
                                    <td>{{ $v->mikrotik_address_list ?: '-' }}</td>
                                    <td>{{ $v->mikrotik_rate_limit }}</td>
                                    <td>{{ $v->shared }}</td>
                                    <td>
                                        @if ($v->kuota == 0)
                                            UNLIMITED
                                        @else
                                            {{ $v->kuota . ' ' . $v->kuota_satuan }}
                                        @endif
                                    </td>
                                    <td>
                                        @if ($v->durasi == 0)
                                            UNLIMITED
                                        @else
                                            {{ $v->durasi . ' ' . $v->durasi_satuan }}
                                        @endif
                                    </td>
                                    <td>{{ $v->masa_aktif . ' ' . $v->masa_aktif_satuan }}</td>
                                    <td>{{ number_format($v->hpp ?? 0, 0, ',', '.') }}</td>
                                    <td>{{ number_format($v->komisi, 0, ',', '.') }}</td>
                                    <td>{{ number_format($v->hjk, 0, ',', '.') }}</td>
                                    <td class="space-x-1">
                                        <a href="{{ route('voucher.edit', $v->id) }}" class="bg-gradient-to-r from-blue-400 to-blue-500 text-white text-sm px-3 py-1 rounded-md font-medium shadow-sm hover:from-blue-500 hover:to-blue-600 transition-all duration-200"><i
                                                class="fas fa-edit"></i> Edit</a>
                                        <form action="{{ route('voucher.delete', $v->id) }}" method="POST"
                                            class="inline-block" onsubmit="return confirm('Yakin mau hapus?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="bg-gradient-to-r from-red-400 to-red-500 text-white text-sm px-3 py-1 rounded-md font-medium shadow-sm hover:from-red-500 hover:to-red-600 transition-all duration-200"><i
                                                    class="fas fa-trash"></i> Hapus</button>
                                        </form>
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
            $('#voucherTable').DataTable({
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
