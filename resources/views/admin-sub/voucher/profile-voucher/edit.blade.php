<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Edit Profile Voucher</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
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

    <!-- Konten -->
    <main class="md:pl-72 pt-20 w-full p-6">

        <div class="flex items-center mb-8">
            <h2
                class="text-4xl font-extrabold tracking-tight text-blue-500 flex items-center">
                <i class="fa-solid fa-pen-to-square w-8 h-8 mr-5 text-blue-500"></i>
                Edit Profile Voucher
            </h2>
        </div>

        <div class="bg-white rounded-xl shadow-md border border-blue-200 border-t-4 border-t-blue-400 p-6">
            <form class="grid grid-cols-1 md:grid-cols-2 gap-6" action="{{ route('voucher.update', $voucher->id) }}"
                method="POST" autocomplete="off">
                @csrf
                @method('PUT')

                <div class="md:col-span-2">
                    <label class="block font-medium mb-1">Nama Profile</label>
                    <input type="text" name="nama_profile" value="{{ old('nama_profile', $voucher->nama_profile) }}"
                        maxlength="200" required
                        class="w-full border border-gray-500 rounded-lg px-3 py-2 shadow-sm focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-400 focus:shadow-lg transition duration-200" />
                </div>

                <div>
                    <label class="block font-medium mb-1">Mikrotik Group</label>
                    <input type="text" name="mikrotik_group"
                        value="{{ old('mikrotik_group', $voucher->mikrotik_group) }}" maxlength="64"
                        class="w-full border border-gray-500 rounded-lg px-3 py-2 shadow-sm focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-400 focus:shadow-lg transition duration-200" />
                    <p class="text-sm text-gray-500">Harus sama dengan nama profile di Mikrotik</p>
                </div>

                <div>
                    <label class="block font-medium mb-1">Mikrotik Address List</label>
                    <input type="text" name="mikrotik_address_list"
                        value="{{ old('mikrotik_address_list', $voucher->mikrotik_address_list) }}" maxlength="64"
                        class="w-full border border-gray-500 rounded-lg px-3 py-2 shadow-sm focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-400 focus:shadow-lg transition duration-200" />
                    <p class="text-sm text-gray-500">Opsional, jika diisi maka setiap user akan ditambahkan ke Address
                        List</p>
                </div>

                <div class="md:col-span-2">
                    <label class="block font-medium mb-1">Mikrotik Rate Limit</label>
                    <input type="text" name="mikrotik_rate_limit"
                        value="{{ old('mikrotik_rate_limit', $voucher->mikrotik_rate_limit) }}" maxlength="100"
                        class="w-full border border-gray-500 rounded-lg px-3 py-2 shadow-sm focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-400 focus:shadow-lg transition duration-200" />
                    <p class="text-sm text-gray-500">Kosongkan untuk memakai limitasi profile Mikrotik</p>
                </div>

                <div>
                    <label class="block font-medium mb-1">Shared</label>
                    <input type="number" name="shared" value="{{ old('shared', $voucher->shared) }}" min="1"
                        max="1000"
                        class="w-full border border-gray-500 rounded-lg px-3 py-2 shadow-sm focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-400 focus:shadow-lg transition duration-200" />
                </div>

                <div>
                    <label class="block font-medium mb-1">Kuota</label>
                    <input type="number" name="kuota" value="{{ old('kuota', $voucher->kuota) }}" min="0"
                        class="w-full border border-gray-500 rounded-lg px-3 py-2 shadow-sm focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-400 focus:shadow-lg transition duration-200" />
                </div>

                <div>
                    <label class="block font-medium mb-1">Satuan Kuota</label>
                    <select name="kuota_satuan"
                        class="w-full border border-gray-500 rounded-lg px-3 py-2 shadow-sm focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-400 focus:shadow-lg transition duration-200">
                        <option value="UNLIMITED" {{ $voucher->kuota_satuan == 'UNLIMITED' ? 'selected' : '' }}>
                            UNLIMITED</option>
                        <option value="MB" {{ $voucher->kuota_satuan == 'MB' ? 'selected' : '' }}>MB</option>
                        <option value="GB" {{ $voucher->kuota_satuan == 'GB' ? 'selected' : '' }}>GB</option>
                    </select>
                </div>

                <div>
                    <label class="block font-medium mb-1">Durasi</label>
                    <input type="number" name="durasi" value="{{ old('durasi', $voucher->durasi) }}" min="0"
                        class="w-full border border-gray-500 rounded-lg px-3 py-2 shadow-sm focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-400 focus:shadow-lg transition duration-200" />
                </div>

                <div>
                    <label class="block font-medium mb-1">Satuan Durasi</label>
                    <select name="durasi_satuan"
                        class="w-full border border-gray-500 rounded-lg px-3 py-2 shadow-sm focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-400 focus:shadow-lg transition duration-200">
                        <option value="UNLIMITED" {{ $voucher->durasi_satuan == 'UNLIMITED' ? 'selected' : '' }}>
                            UNLIMITED</option>
                        <option value="HARI" {{ $voucher->durasi_satuan == 'HARI' ? 'selected' : '' }}>HARI</option>
                        <option value="JAM" {{ $voucher->durasi_satuan == 'JAM' ? 'selected' : '' }}>JAM</option>
                        <option value="MENIT" {{ $voucher->durasi_satuan == 'MENIT' ? 'selected' : '' }}>MENIT
                        </option>
                    </select>
                </div>

                <div>
                    <label class="block font-medium mb-1">Masa Aktif</label>
                    <input type="number" name="masa_aktif" value="{{ old('masa_aktif', $voucher->masa_aktif) }}"
                        min="1" max="5000"
                        class="w-full border border-gray-500 rounded-lg px-3 py-2 shadow-sm focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-400 focus:shadow-lg transition duration-200" />
                </div>

                <div>
                    <label class="block font-medium mb-1">Satuan Masa Aktif</label>
                    <select name="masa_aktif_satuan"
                        class="w-full border border-gray-500 rounded-lg px-3 py-2 shadow-sm focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-400 focus:shadow-lg transition duration-200">
                        <option value="HARI" {{ $voucher->masa_aktif_satuan == 'HARI' ? 'selected' : '' }}>HARI
                        </option>
                        <option value="JAM" {{ $voucher->masa_aktif_satuan == 'JAM' ? 'selected' : '' }}>JAM
                        </option>
                        <option value="MENIT" {{ $voucher->masa_aktif_satuan == 'MENIT' ? 'selected' : '' }}>MENIT
                        </option>
                    </select>
                </div>

                <div>
                    <label class="block font-medium mb-1">HPP</label>
                    <input type="text" name="hpp" value="{{ old('hpp', $voucher->hpp) }}"
                        class="w-full border border-gray-500 rounded-lg px-3 py-2 shadow-sm focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-400 focus:shadow-lg transition duration-200" />
                    <p class="text-sm text-gray-500">Harga pokok produksi</p>
                </div>

                <div>
                    <label class="block font-medium mb-1">Komisi</label>
                    <input type="text" name="komisi" value="{{ old('komisi', $voucher->komisi) }}"
                        class="w-full border border-gray-500 rounded-lg px-3 py-2 shadow-sm focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-400 focus:shadow-lg transition duration-200" />
                    <p class="text-sm text-gray-500">Komisi reseller setiap voucher</p>
                </div>

                <div>
                    <label class="block font-medium mb-1">HJK</label>
                    <input type="text" name="hjk" value="{{ old('hjk', $voucher->hjk) }}"
                        class="w-full border border-gray-500 rounded-lg px-3 py-2 shadow-sm focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-400 focus:shadow-lg transition duration-200" />
                    <p class="text-sm text-gray-500">Harga jual ke konsumen</p>
                </div>

                <div class="md:col-span-2 flex gap-3 mt-6 justify-end">
                    <a href="{{ route('voucher.index') }}"
                        class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg shadow-md transition-all duration-200">
                        <i class="fa-solid fa-arrow-left mr-1"></i> Kembali
                    </a>
                    <button type="reset"
                        class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-lg shadow-md transition-all duration-200">
                        <i class="fa-solid fa-rotate-left mr-1"></i> Reset
                    </button>
                    <button type="submit"
                        class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg shadow-md transition-all duration-200">
                        <i class="fa-solid fa-save mr-1"></i> Simpan
                    </button>
                </div>

            </form>
        </div>

    </main>
</body>

</html>
