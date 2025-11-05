<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Mitra - BNC Cloud Manager</title>

    <!-- Tailwind -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- jQuery & DataTables -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="{{ asset('css/datatable.css') }}">
    <link rel="stylesheet" href="{{ asset('css/popup.css') }}">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

</head>

<body class="bg-gray-50 min-h-screen">

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
            <h2 class="text-4xl font-extrabold tracking-tight text-blue-500 flex items-center">
                <i class="fas fa-users w-8 h-8 mr-5 text-blue-500"></i>Daftar Mitra
            </h2>
        </div>

        <!-- Card -->
        <div class="bg-white rounded-2xl shadow-lg border border-blue-200 border-t-4 border-t-blue-400 p-6">

            <div
                class="group mb-6 relative rounded-xl bg-white p-6 shadow-xl shadow-blue-100 border border-blue-100 overflow-hidden transition-all duration-500">
                <div class="flex flex-col gap-3 relative z-10">
                    <div class="flex items-center gap-3 border-b border-blue-100 pb-3">
                        <div class="text-blue-600">
                            <i class="fa-solid fa-circle-info text-2xl"></i>
                        </div>
                        <h3 class="text-lg font-semibold text-blue-800">
                            Informasi Penting Mengenai Mitra
                        </h3>
                    </div>

                    <div class="text-gray-700 text-sm leading-relaxed space-y-1 pt-1">
                        <p>
                            <span class="font-bold text-blue-800">• Saldo bertanda minus (-)</span> menandakan mitra
                            berhutang sejumlah tersebut, dan mitra masih dapat bertransaksi hingga batas limit hutang.
                        </p>
                        <p>
                            <span class="font-bold text-blue-800">• Reseller</span> dapat mengelola data voucher dan
                            pelanggan sendiri serta mendapat komisi per transaksi.
                        </p>
                        <p>
                            <span class="font-bold text-blue-800">• Biller</span> berfungsi sebagai penerima pembayaran
                            tagihan seperti loket atau kolektor langganan.
                        </p>
                    </div>
                </div>
            </div>
            <!-- Tombol Modal -->
            <div class="mb-6 flex gap-3">
                <a href="{{ route('resellers.create') }}"
                    class="flex items-center gap-2 bg-emerald-500 text-white px-4 py-2 rounded-md font-medium shadow-md hover:bg-emerald-600 transition duration-500">
                    <i class="fas fa-user-plus"></i> Tambah Reseller
                </a>
            </div>

            <div id="loading" class="flex justify-center items-center py-10">
                <div class="w-10 h-10 border-4 border-blue-400 border-t-transparent rounded-full animate-spin">
                </div>
            </div>

            <div id="tableContainer" class="hidden bg-white shadow-lg rounded-2xl p-6 overflow-x-auto">
                <table id="mitraTable" class="display w-full">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nama</th>
                            <th>Kategori</th>
                            <th>Stok VC</th>
                            <th>Telepon</th>
                            <th>Alamat</th>
                            <th>Saldo</th>
                            <th>Limit Hutang</th>
                            <th>Kode Unik</th>
                            <th>Komisi</th>
                            <th>Login Terakhir</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($resellers as $reseller)
                            <tr>
                                <td>{{ $reseller->id }}</td>
                                <td>{{ $reseller->nama_lengkap }}</td>
                                <td>{{ strtoupper($reseller->kategori ?? 'RESELLER') }}</td>
                                <td>{{ $reseller->stok_vc ?? 0 }}</td>
                                <td>{{ $reseller->telepon }}</td>
                                <td>{{ $reseller->alamat }}</td>
                                <td>{{ number_format($reseller->saldo ?? 0, 0, ',', '.') }}</td>
                                <td>{{ number_format($reseller->limit_hutang ?? 0, 0, ',', '.') }}</td>
                                <td>{{ $reseller->kode_unik ?? '-' }}</td>
                                <td>{{ number_format($reseller->komisi ?? 0, 0, ',', '.') }}</td>
                                <td>{{ $reseller->login_terakhir ? $reseller->login_terakhir->format('d-m-Y H:i') : '-' }}
                                </td>
                                <td class="flex justify-center items-center gap-2 align-middle">
                                    <a href="{{ route('resellers.edit', $reseller->id) }}"
                                        class="flex items-center justify-center gap-1 bg-gradient-to-r from-blue-400 to-blue-500 text-white text-sm px-3 py-1 rounded-md font-medium shadow-sm hover:from-blue-500 hover:to-blue-600 transition-all duration-200">
                                        <i class="fas fa-pen text-xs"></i>
                                        Edit
                                    </a>

                                    <form action="{{ route('resellers.delete', $reseller->id) }}" method="POST"
                                        onsubmit="return confirm('Yakin hapus reseller ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="flex items-center justify-center gap-1 bg-gradient-to-r from-red-400 to-red-500 text-white text-sm px-3 py-1 rounded-md font-medium shadow-sm hover:from-red-500 hover:to-red-600 transition-all duration-200">
                                            <i class="fas fa-trash text-xs"></i>
                                            Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            @if (method_exists($resellers, 'links'))
                <div class="mt-3">
                    {{ $resellers->links() }}
                </div>
            @endif
        </div>
    </main>

    <script>
        $(document).ready(function() {
            $('#mitraTable').DataTable({
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
