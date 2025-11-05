<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <title>Tambah Reseller</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
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
        <div class="flex items-center mb-8">
            <h2 class="text-4xl font-extrabold tracking-tight text-blue-500 flex items-center">
                <i class="fas fa-user-plus w-8 h-8 mr-5 text-blue-500"></i>Tambah Reseller
            </h2>
        </div>

        <div class="bg-white rounded-2xl shadow-lg border border-blue-200 border-t-4 border-t-blue-400 p-6">
            <form class="grid grid-cols-1 md:grid-cols-2 gap-8" action="{{ route('resellers.store') }}" method="POST">
                @csrf
                <input type="hidden" name="level" value="11">

                <!-- Data Reseller -->
                <div class="md:col-span-1">
                    <h5 class="text-xl font-semibold text-blue-600 mb-5 border-b pb-2 flex items-center gap-2">
                        <i class="fa-solid fa-id-card text-blue-500"></i> Data Reseller
                    </h5>

                    <div class="space-y-4">
                        <div>
                            <label class="block font-medium text-gray-700 mb-1">Nama Lengkap</label>
                            <input type="text" name="nama_lengkap" required
                                class="w-full border border-gray-500 rounded-lg px-3 py-2 shadow-sm focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-400 focus:shadow-lg transition duration-200">
                        </div>
                        <div>
                            <label class="block font-medium text-gray-700 mb-1">No. Identitas</label>
                            <input type="text" name="no_identitas" required
                                class="w-full border border-gray-500 rounded-lg px-3 py-2 shadow-sm focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-400 focus:shadow-lg transition duration-200">
                        </div>
                        <div>
                            <label class="block font-medium text-gray-700 mb-1">Telepon</label>
                            <input type="text" name="telepon" required
                                class="w-full border border-gray-500 rounded-lg px-3 py-2 shadow-sm focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-400 focus:shadow-lg transition duration-200">
                        </div>
                        <div>
                            <label class="block font-medium text-gray-700 mb-1">Alamat Lengkap</label>
                            <textarea name="alamat" rows="3" required
                                class="w-full border border-gray-500 rounded-lg px-3 py-2 shadow-sm focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-400 focus:shadow-lg transition duration-200"></textarea>
                        </div>
                        <div>
                            <label class="block font-medium text-gray-700 mb-1">Username Login</label>
                            <input type="text" name="username" required
                                class="w-full border border-gray-500 rounded-lg px-3 py-2 shadow-sm focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-400 focus:shadow-lg transition duration-200">
                        </div>
                        <div>
                            <label class="block font-medium text-gray-700 mb-1">Password Login</label>
                            <input type="text" name="password" value="0123456"
                                class="w-full border border-gray-500 rounded-lg px-3 py-2 shadow-sm focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-400 focus:shadow-lg transition duration-200">
                        </div>
                        <div>
                            <label class="block font-medium text-gray-700 mb-1">Tanggal Bergabung</label>
                            <input type="date" name="tgl_bergabung" required
                                class="tanggal w-full border border-gray-500 rounded-lg px-3 py-2 shadow-sm focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-400 focus:shadow-lg transition duration-200">
                        </div>
                        <div>
                            <label class="block font-medium text-gray-700 mb-1">Limit Hutang</label>
                            <input type="number" name="limit_hutang" value="0"
                                class="w-full border border-gray-500 rounded-lg px-3 py-2 shadow-sm focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-400 focus:shadow-lg transition duration-200">
                        </div>
                        <div>
                            <label class="block font-medium text-gray-700 mb-1">Kode Unik</label>
                            <input type="number" name="kode_unik" value="0" min="0" max="9999"
                                class="w-full border border-gray-500 rounded-lg px-3 py-2 shadow-sm focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-400 focus:shadow-lg transition duration-200">
                        </div>
                    </div>
                </div>

                <!-- Hak Akses -->
                <div class="md:col-span-1">
                    <h5 class="text-xl font-semibold text-blue-600 mb-5 border-b pb-2 flex items-center gap-2">
                        <i class="fa-solid fa-lock text-blue-500"></i> Hak Akses
                    </h5>

                    <div class="space-y-6">

                        <!-- Router -->
                        <div class="bg-gray-50 p-5 rounded-xl border border-gray-200 shadow-sm hover:shadow-md transition">
                            <label class="font-semibold block mb-3 text-gray-800 flex items-center gap-2">
                                <i class="fa-solid fa-network-wired text-blue-500"></i> Router
                            </label>
                            <div class="space-y-2 pl-2 text-gray-700">
                                <label class="flex items-center gap-2">
                                    <input type="checkbox" name="hak_akses_router[]" value="ALL" checked
                                        class="accent-blue-500 scale-110">
                                    Semua Router
                                </label>
                                <label class="flex items-center gap-2">
                                    <input type="checkbox" name="hak_akses_router[]" value="NONE"
                                        class="accent-blue-500 scale-110">
                                    Tidak Ada
                                </label>
                                <label class="flex items-center gap-2">
                                    <input type="checkbox" name="hak_akses_router[]" value="1"
                                        class="accent-blue-500 scale-110">
                                    SERVER BNC
                                </label>
                            </div>
                        </div>

                        <!-- Server -->
                        <div class="bg-gray-50 p-5 rounded-xl border border-gray-200 shadow-sm hover:shadow-md transition">
                            <label class="font-semibold block mb-3 text-gray-800 flex items-center gap-2">
                                <i class="fa-solid fa-server text-blue-500"></i> Server
                            </label>
                            <div class="space-y-2 pl-2 text-gray-700">
                                <label class="flex items-center gap-2">
                                    <input type="checkbox" name="hak_akses_server[]" value="ALL" checked
                                        class="accent-blue-500 scale-110">
                                    Semua Server
                                </label>
                                <label class="flex items-center gap-2">
                                    <input type="checkbox" name="hak_akses_server[]" value="NONE"
                                        class="accent-blue-500 scale-110">
                                    Tidak Ada
                                </label>
                                <label class="flex items-center gap-2">
                                    <input type="checkbox" name="hak_akses_server[]" value="1"
                                        class="accent-blue-500 scale-110">
                                    hotspot1
                                </label>
                                <label class="flex items-center gap-2">
                                    <input type="checkbox" name="hak_akses_server[]" value="2"
                                        class="accent-blue-500 scale-110">
                                    server1
                                </label>
                            </div>
                        </div>

                        <!-- Profile -->
                        <div class="bg-gray-50 p-5 rounded-xl border border-gray-200 shadow-sm hover:shadow-md transition">
                            <label class="font-semibold block mb-3 text-gray-800 flex items-center gap-2">
                                <i class="fa-solid fa-user-shield text-blue-500"></i> Profile
                            </label>
                            <div class="space-y-2 pl-2 text-gray-700">
                                <label class="flex items-center gap-2">
                                    <input type="checkbox" name="hak_akses_profile[]" value="ALL" checked
                                        class="accent-blue-500 scale-110">
                                    Semua Profile
                                </label>
                                <label class="flex items-center gap-2">
                                    <input type="checkbox" name="hak_akses_profile[]" value="NONE"
                                        class="accent-blue-500 scale-110">
                                    Tidak Ada
                                </label>

                                <b class="block mt-3 text-gray-800">Profile Langganan</b>
                                <label class="flex items-center gap-2">
                                    <input type="checkbox" name="hak_akses_profile[]" value="2"
                                        class="accent-blue-500 scale-110">
                                    10Mbps
                                </label>

                                <b class="block mt-3 text-gray-800">Profile Voucher</b>
                                <label class="flex items-center gap-2">
                                    <input type="checkbox" name="hak_akses_profile[]" value="1"
                                        class="accent-blue-500 scale-110">
                                    YYYYY
                                </label>
                                <label class="flex items-center gap-2">
                                    <input type="checkbox" name="hak_akses_profile[]" value="3"
                                        class="accent-blue-500 scale-110">
                                    vc1
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tombol -->
                <div class="md:col-span-2 flex gap-3 mt-8 justify-end">
                    <a href="{{ route('resellers.index') }}"
                        class="bg-gray-500 hover:bg-gray-600 text-white px-5 py-2.5 rounded-lg shadow-md transition duration-200 flex items-center gap-2">
                        <i class="fa-solid fa-arrow-left"></i> Kembali
                    </a>
                    <button type="reset"
                        class="bg-yellow-500 hover:bg-yellow-600 text-white px-5 py-2.5 rounded-lg shadow-md transition duration-200 flex items-center gap-2">
                        <i class="fa-solid fa-rotate-left"></i> Reset
                    </button>
                    <button type="submit"
                        class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2.5 rounded-lg shadow-md transition duration-200 flex items-center gap-2">
                        <i class="fa-solid fa-save"></i> Simpan
                    </button>
                </div>
            </form>
        </div>
    </main>

    <!-- ✅ Flatpickr -->
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script>
        flatpickr(".tanggal", {
            dateFormat: "Y-m-d",
            allowInput: true,
            altInput: true,
            altFormat: "d-m-Y",
            theme: "light",
        });
    </script>

</body>
</html>
