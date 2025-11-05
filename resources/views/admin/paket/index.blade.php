<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>CRUD Paket - BNC Cloud Manager</title>

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
    @include('layouts.adminbar')

    <main class="md:pl-72 pt-20 w-full p-6">

        <!-- Header -->
        <div class="flex items-center mb-8">
            <h2 class="text-4xl font-extrabold tracking-tight text-blue-500 flex items-center">
                <i class="fas fa-network-wired w-8 h-8 mr-5 text-blue-500"></i>
                Daftar Paket Internet
            </h2>
        </div>

        <!-- Card -->
        <div class="p-2">
            <div class="bg-white rounded-2xl shadow-lg border border-blue-200 border-t-4 border-t-blue-400 p-6">

                <!-- Tombol Tambah -->
                <div class="mb-6 flex gap-3">
                    <a href="{{ route('paket.create') }}"
                        class="flex items-center gap-2 bg-emerald-500 text-white px-4 py-2 rounded-md font-medium shadow-md hover:bg-emerald-600 transition duration-500">
                        <i class="fa-solid fa-plus"></i> Tambah Paket
                    </a>
                </div>

                <div id="loading" class="flex justify-center items-center py-10">
                    <div class="w-10 h-10 border-4 border-blue-400 border-t-transparent rounded-full animate-spin">
                    </div>
                </div>

                <!-- Tabel Paket -->
                <div id="tableContainer" class="hidden bg-white shadow-lg rounded-2xl p-6 overflow-x-auto">
                    <table id="paketTable" class="display w-full">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Harga Bulanan</th>
                                <th>Harga Tahunan</th>
                                <th>Mikrotik</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($pakets as $index => $paket)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td class="text-left">{{ $paket->nama }}</td>
                                    <td class="text-left">Rp
                                        {{ number_format((float) $paket->harga_bulanan, 0, ',', '.') }}
                                    </td>
                                    <td class="text-left">Rp
                                        {{ number_format((float) $paket->harga_tahunan, 0, ',', '.') }}
                                    </td>
                                    <td>{{ $paket->mikrotik }}</td>
                                    <td>
                                        <div class="flex items-center justify-center gap-2">
                                            <!-- Edit -->
                                            <a href="{{ route('paket.edit', $paket->id) }}"
                                                class="flex items-center justify-center gap-1 bg-gradient-to-r from-blue-400 to-blue-500 text-white text-sm px-3 py-1 rounded-md font-medium shadow-sm hover:from-blue-500 hover:to-blue-600 transition-all duration-200"
                                                title="Edit Paket">
                                                <i class="fa-solid fa-pen text-xs"></i>Edit
                                            </a>

                                            <!-- Hapus -->
                                            <form action="{{ route('paket.destroy', $paket->id) }}" method="POST"
                                                onsubmit="return confirm('Yakin ingin menghapus paket ini?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="flex items-center justify-center gap-1 bg-gradient-to-r from-red-400 to-red-500 text-white text-sm px-3 py-1 rounded-md font-medium shadow-sm hover:from-red-500 hover:to-red-600 transition-all duration-200"
                                                    title="Hapus Paket">
                                                    <i class="fa-solid fa-trash text-xs"></i>Hapus
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>

    <!-- Init DataTables -->
    <script>
        $(document).ready(function() {
            $('#paketTable').DataTable({
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
