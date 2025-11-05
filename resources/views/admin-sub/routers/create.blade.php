<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Router</title>
    <script src="https://cdn.tailwindcss.com"></script>
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
                ipInput.value = "172.31." + Math.floor(Math.random()*256) + "." + Math.floor(Math.random()*256);
            }
        }
    </script>
</head>

<body class="bg-gray-100 min-h-screen">

    <!-- Sidebar sesuai role -->
    @if(Auth::user()->level === 'administrator')
      @include('layouts.subadminbar')
    @elseif(Auth::user()->level === 'keuangan')
      @include('layouts.keuanganbar')
    @elseif(Auth::user()->level === 'operator')
      @include('layouts.operatorbar')
    @elseif(Auth::user()->level === 'teknisi')
      @include('layouts.teknisibar')
    @endif

    <div class="p-6 sm:ml-64 flex justify-center items-center">
        <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-lg">
            <h1 class="text-2xl font-bold mb-4">Tambah Router MikroTik</h1>

            <form action="{{ route('routers.store') }}" method="POST" class="space-y-4" onsubmit="setDefaultIpIfVPN()">
                @csrf

                <!-- Nama Router -->
                <div>
                    <label class="block font-medium mb-1">Nama Router</label>
                    <input type="text" name="nama_router" 
                           class="w-full border border-gray-300 rounded px-3 py-2 focus:ring focus:ring-blue-200 focus:border-blue-500" 
                           required>
                </div>

                <!-- Tipe Koneksi -->
                <div>
                    <label class="block font-medium mb-1">Tipe Koneksi</label>
                    <select name="tipe_koneksi" id="tipe_koneksi" onchange="toggleIpField()" 
                            class="w-full border border-gray-300 rounded px-3 py-2 focus:ring focus:ring-blue-200 focus:border-blue-500" 
                            required>
                        <option value="">- Pilih -</option>
                        <option value="ip_public">IP Public</option>
                        <option value="vpn_radius">VPN Radius</option>
                    </select>
                </div>

                <!-- IP Address -->
                <div class="hidden" id="ip_field">
                    <label class="block font-medium mb-1">IP Address</label>
                    <input type="text" name="ip_address" placeholder="Contoh: 123.45.67.89" 
                           class="w-full border border-gray-300 rounded px-3 py-2 focus:ring focus:ring-blue-200 focus:border-blue-500">
                </div>

                <!-- Submit -->
                <div class="pt-2">
                    <button type="submit" 
                            class="w-full bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded transition">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>

</body>
</html>
