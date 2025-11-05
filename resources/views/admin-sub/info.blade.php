<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Info Log - BNC CLOUD MANAGER</title>

    <!-- Tailwind -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- jQuery & DataTables -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="{{ asset('css/datatable.css') }}">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

    <!-- Flatpickr -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr" defer></script>

    <style>
        .clear-btn {
            color: #9ca3af;
            cursor: pointer;
            transition: color 0.2s ease;
        }

        .clear-btn:hover {
            color: #ef4444;
        }
    </style>
</head>

<body class="bg-gray-50 flex min-h-screen">

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
        <div class="flex items-center mb-8">
            <h2 class="text-4xl font-extrabold tracking-tight text-blue-500 flex items-center">
                <i class="fa-solid fa-clipboard-list w-8 h-8 mr-4 text-blue-500"></i>
                Info Log
            </h2>
        </div>

        <div class="bg-white rounded-2xl shadow-lg border border-blue-200 border-t-4 border-t-blue-400 p-6">

            <!-- Tombol & Filter -->
            <div class="mb-6 flex flex-col md:flex-row md:items-center justify-between gap-4">
                <form action="{{ route('info.destroyAll') }}" method="POST"
                    onsubmit="return confirm('Kosongkan semua log?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                        class="flex items-center gap-2 bg-red-500 text-white px-4 py-2 rounded-md font-medium shadow-md hover:bg-red-600 transition duration-500">
                        <i class="fa fa-trash"></i> Kosongkan Log
                    </button>
                </form>

                <!-- Filter tanggal + tombol clear -->
                <div class="flex items-center gap-2">
                    <label class="text-sm font-medium text-gray-700">Filter Tanggal</label>
                    <div class="flex items-center gap-2 bg-white border border-gray-300 rounded-lg shadow-sm px-3 py-2">
                        <input type="text" id="filterTanggal"
                            class="focus:ring-0 focus:outline-none w-40 flatpickr-input" placeholder="Pilih tanggal"
                            readonly />
                        <i id="clearFilter" class="fa-solid fa-xmark clear-btn" title="Hapus filter"></i>
                    </div>
                </div>
            </div>

            <div id="loading" class="flex justify-center items-center py-10">
                <div class="w-10 h-10 border-4 border-blue-400 border-t-transparent rounded-full animate-spin">
                </div>
            </div>

            <!-- === TABEL === -->
            <div id="tableContainer" class="hidden bg-white shadow-lg rounded-2xl p-6 overflow-x-auto">
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
    </main>

    <script defer>
        $(document).ready(function() {
            // Inisialisasi DataTables
            const logTable = $('#logTable').DataTable({
                responsive: true,
                autoWidth: false,
                ordering: false,
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/id.json'
                },
                initComplete: function() {
                    $('#loading').hide();
                    $('#tableContainer').removeClass('hidden').hide().fadeIn(200);
                }
            });

            // Inisialisasi Flatpickr
            const fp = flatpickr("#filterTanggal", {
                dateFormat: "Y-m-d",
                allowInput: true,
                onChange: function(selectedDates, dateStr) {
                    logTable.column(5).search(dateStr).draw();
                }
            });

            // Tombol hapus filter
            $('#clearFilter').on('click', function() {
                fp.clear();
                logTable.column(5).search('').draw();
            });
        });
    </script>

</body>

</html>
