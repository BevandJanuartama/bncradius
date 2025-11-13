<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Daftar Router - BNC Cloud Manager</title>

    <!-- Tailwind -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- jQuery & DataTables -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="{{ asset('css/datatable.css') }}">
    <link rel="stylesheet" href="{{ asset('css/popup.css') }}">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

    <style>
        /* Teks secret */
        .secret-text {
            position: relative;
            cursor: pointer;
            color: #4b5563;
        }

        .secret-text::after {
            content: attr(data-secret);
            position: absolute;
            left: 0;
            top: 0;
            background: #fff;
            padding: 0 5px;
            opacity: 0;
            transition: opacity 0.2s ease;
            border-radius: 4px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            z-index: 10;
            font-size: 13px;
            color: #1e3a8a;
        }

        .secret-text:hover::after {
            opacity: 1;
        }
    </style>

    <script>
        function toggleIpField() {
            const tipe = document.getElementById('tipe_koneksi').value;
            const ipField = document.getElementById('ip_field');
            if (tipe === 'ip_public') {
                ipField.classList.remove('hidden');
            } else {
                ipField.classList.add('hidden');
            }
        }

        function setDefaultIpIfVPN() {
            const tipe = document.getElementById('tipe_koneksi').value;
            const ipInput = document.querySelector('input[name="ip_address"]');
            if (tipe === 'vpn_radius') {
                ipInput.value = "172.31." + Math.floor(Math.random() * 256) + "." + Math.floor(Math.random() * 256);
            }
        }
    </script>
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
            <h2 class="text-4xl font-extrabold tracking-tight text-blue-500 flex items-center">
                <i class="fa-solid fa-network-wired w-8 h-8 mr-5 text-blue-500"></i>Daftar Router
            </h2>
        </div>

        <!-- Card -->
        <div class="bg-white rounded-2xl shadow-lg border border-blue-200 border-t-4 border-t-blue-400 p-6">

            <!-- Tombol Modal -->
            <div class="mb-6 flex gap-3">
                <button onclick="openModal()"
                    class="flex items-center gap-2 bg-emerald-500 text-white px-4 py-2 rounded-md font-medium shadow-md hover:bg-emerald-600 transition duration-500">
                    <i class="fa-solid fa-circle-plus"></i>
                    Tambah Router
                </button>
            </div>

            <div id="loading" class="flex justify-center items-center py-10">
                <div class="w-10 h-10 border-4 border-blue-400 border-t-transparent rounded-full animate-spin">
                </div>
            </div>

            <div id="tableContainer" class="hidden bg-white shadow-lg rounded-2xl p-6 overflow-x-auto">
                <table id="routerTable" class="display w-full">
                    <thead>
                        <tr>
                            <th>Nama Router</th>
                            <th>Tipe Koneksi</th>
                            <th>IP Address</th>
                            <th>Secret</th>
                            <th>Status</th>
                            <th>Script</th>
                            <th>SNMP</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($routers as $router)
                            <tr>
                                <td>{{ $router->nama_router }}</td>
                                <td>
                                    {{ $router->tipe_koneksi == 'ip_public'
                                        ? 'IP PUBLIC'
                                        : ($router->tipe_koneksi == 'vpn_radius'
                                            ? 'VPN RADIUS'
                                            : $router->tipe_koneksi) }}
                                </td>
                                <td>{{ $router->ip_address ?? '-' }}</td>
                                <td>
                                    <span class="secret-text" data-secret="{{ $router->secret }}">**********</span>
                                </td>
                                <td>
                                    @if ($router->online)
                                        <span
                                            class="px-2 py-1 text-xs font-semibold text-green-500 bg-green-100 border border-green-200 rounded-full">Online</span>
                                    @else
                                        <span
                                            class="px-2 py-1 text-xs font-semibold text-red-500 bg-red-100 border border-red-200 rounded-full">Offline</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('routers.download', $router->id) }}"
                                        class="px-3 py-1 text-xs bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white rounded-lg transition">
                                        <i class="fa-solid fa-download"></i> Download
                                    </a>
                                </td>
                                <td>
                                    @if ($router->snmp_status)
                                        <button
                                            class="px-3 py-1 text-xs font-semibold text-green-700 bg-green-100 border border-green-200 rounded-full hover:bg-green-200 transition"
                                            onclick="alert('SNMP Connected: {{ $router->nama_router }}')">
                                            Connected
                                        </button>
                                    @else
                                        <button
                                            id="statusButton"
                                            class="px-3 py-1 text-xs font-semibold text-red-700 bg-red-100 border border-red-200 rounded-full hover:bg-red-200 transition"
                                            onclick="toggleStatus(this, '{{ $router->nama_router }}')">
                                            Disconnected
                                        </button>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </main>

    <!-- Modal Create Router -->
    <div id="createModal" class="popup-modal hidden">
        <div id="popupContent" class="popup-content bg-white rounded-lg shadow-lg p-6 w-full max-w-lg">


            <!-- Header Modal -->
            <div class="flex items-center mb-6 ">
                <div class="p-2 bg-blue-500 rounded-lg text-white mr-3">
                    <i class="fa-solid fa-network-wired text-xl"></i>
                </div>
                <h1 class="text-2xl font-bold text-gray-800 tracking-wide">Tambah Router MikroTik</h1>
            </div>

            <!-- Form -->
            <form action="{{ route('routers.store') }}" method="POST" class="space-y-5" onsubmit="setDefaultIpIfVPN()">
                @csrf

                <!-- Nama Router -->
                <div>
                    <label class="block font-medium text-gray-700 mb-1">Nama Router</label>
                    <input type="text" name="nama_router"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                        placeholder="Contoh: Router Kantor Utama" required>
                </div>

                <!-- Tipe Koneksi -->
                <div>
                    <label class="block font-medium text-gray-700 mb-1">Tipe Koneksi</label>
                    <select name="tipe_koneksi" id="tipe_koneksi" onchange="toggleIpField()"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                        required>
                        <option value="">- Pilih -</option>
                        <option value="ip_public">IP Public</option>
                        <option value="vpn_radius">VPN Radius</option>
                    </select>
                </div>

                <!-- IP Address -->
                <div class="hidden" id="ip_field">
                    <label class="block font-medium text-gray-700 mb-1">IP Address</label>
                    <input type="text" name="ip_address" placeholder="Contoh: 123.45.67.89"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                </div>

                <!-- Tombol Simpan -->
                <div class="flex justify-end gap-3 mt-6">
                                        <button type="submit"
                        class="flex justify-center items-center gap-2 bg-gradient-to-r from-blue-400 to-blue-500 hover:from-blue-500 hover:to-blue-600 text-white px-4 py-2 rounded-lg shadow-md transition-all duration-200">
                        <i class="fa-solid fa-floppy-disk"></i> Simpan Router
                    </button>

                    <button type="button" onclick="closeModal()"
                        class="flex justify-center items-center gap-2 bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded-lg shadow-md transition-all duration-200">
                        <i class="fa-solid fa-arrow-left"></i> Batal
                    </button>
                </div>

            </form>
        </div>
    </div>


    <script>
        function openModal() {
            document.getElementById('createModal').classList.remove('hidden');
        }

        function closeModal() {
            document.getElementById('createModal').classList.add('hidden');
        }

        function toggleStatus(button, routerName) {
            const isDisconnected = button.textContent.trim() === 'Disconnected';
            
            if (isDisconnected) {
                // Ubah ke Connected (hijau)
                button.textContent = 'Connected';
                button.className = 'px-3 py-1 text-xs font-semibold text-green-700 bg-green-100 border border-green-200 rounded-full hover:bg-green-200 transition';
                alert('SNMP Connected: ' + routerName);
            } else {
                // Ubah ke Disconnected (merah)
                button.textContent = 'Disconnected';
                button.className = 'px-3 py-1 text-xs font-semibold text-red-700 bg-red-100 border border-red-200 rounded-full hover:bg-red-200 transition';
                alert('SNMP Disconnected: ' + routerName);
            }
        }
    </script>


    <!-- Init DataTables -->
    <script>
        $(document).ready(function() {
            $('#routerTable').DataTable({
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
