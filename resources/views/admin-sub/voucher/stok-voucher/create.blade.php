<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Buat Voucher</title>

    <!-- Tailwind -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>
</head>

<body class="bg-gray-100 flex min-h-screen">

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

        <!-- Header -->
        <div class="flex items-center mb-8">
            <h2 class="text-4xl font-extrabold tracking-tight text-blue-500 flex items-center">
                <i class="fa-solid fa-circle-plus w-8 h-8 mr-5 text-blue-500"></i>
                Buat Voucher
            </h2>
        </div>

        <!-- Card Form -->
        <div class="bg-white rounded-xl shadow-md border border-blue-200 border-t-4 border-t-blue-400 p-6">
            {{-- Flash & validation messages --}}
            @if (session('success'))
                <div class="bg-green-600 text-white px-4 py-2 rounded mb-4">{{ session('success') }}</div>
            @endif
            @if (session('error'))
                <div class="bg-red-600 text-white px-4 py-2 rounded mb-4">{{ session('error') }}</div>
            @endif
            @if ($errors->any())
                <div class="bg-red-600 text-white px-4 py-2 rounded mb-4">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form id="voucherForm" action="{{ route('stokvoucher.store') }}" method="POST"
                class="grid grid-cols-1 md:grid-cols-12 gap-6" autocomplete="off">
                @csrf

                <!-- Form kiri -->
                <div class="md:col-span-8 space-y-4">
                    {{-- Mitra --}}
                    <div>
                        <label class="block font-medium mb-1">Mitra</label>
                        <select name="reseller_id" id="reseller_id"
                            class="w-full border border-gray-500 rounded-lg px-3 py-2 shadow-sm focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-400 focus:shadow-lg transition duration-200">
                            <option value="">Pilih Mitra</option>
                            @foreach ($resellers as $reseller)
                                <option value="{{ $reseller->id }}"
                                    data-router="{{ $reseller->hak_akses_router ?? '' }}"
                                    data-server="{{ $reseller->hak_akses_server ?? '' }}"
                                    {{ old('reseller_id') == $reseller->id ? 'selected' : '' }}>
                                    {{ $reseller->nama_lengkap }}
                                </option>
                            @endforeach
                        </select>
                        <p class="text-sm text-gray-500">Komisi otomatis dihilangkan apabila mitranya SYSTEM</p>
                    </div>

                    {{-- Potong Saldo --}}
                    <div>
                        <label class="block font-medium mb-1">Potong Saldo</label>
                        <select name="saldo"
                            class="w-full border border-gray-500 rounded-lg px-3 py-2 shadow-sm focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-400 focus:shadow-lg transition duration-200">
                            <option value="YES" {{ old('saldo', 'YES') == 'YES' ? 'selected' : '' }}>YES</option>
                            <option value="NO" {{ old('saldo') == 'NO' ? 'selected' : '' }}>NO</option>
                        </select>
                    </div>

                    {{-- Router & Server --}}
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block font-medium mb-1">Router</label>
                            <input type="text" id="router" name="router" readonly
                                class="w-full border bg-gray-100 border-gray-500 rounded-lg px-3 py-2 shadow-sm focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-400 focus:shadow-lg transition duration-200" />
                        </div>
                        <div>
                            <label class="block font-medium mb-1">Server</label>
                            <input type="text" id="server" name="server" readonly
                                class="w-full border bg-gray-100 border-gray-500 rounded-lg px-3 py-2 shadow-sm focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-400 focus:shadow-lg transition duration-200" />
                        </div>
                    </div>

                    {{-- Profile --}}
                    <div>
                        <label class="block font-medium mb-1">Profile <span class="text-red-500">*</span></label>
                        <select name="profile_voucher_id" id="profile_voucher_id" required
                            class="w-full border border-gray-500 rounded-lg px-3 py-2 shadow-sm focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-400 focus:shadow-lg transition duration-200">
                            <option value="">Pilih Profile</option>
                            @foreach ($profiles as $profile)
                                <option value="{{ $profile->id }}" data-hpp="{{ $profile->hpp }}"
                                    data-hjk="{{ $profile->hjk }}" data-komisi="{{ $profile->komisi }}"
                                    {{ old('profile_voucher_id') == $profile->id ? 'selected' : '' }}>
                                    {{ $profile->nama_profile }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Jenis Voucher --}}
                    <div>
                        <label class="block font-medium mb-1">Jenis Voucher</label>
                        <select name="jenis_voucher" required
                            class="w-full border border-gray-500 rounded-lg px-3 py-2 shadow-sm focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-400 focus:shadow-lg transition duration-200">
                            <option value="username_password"
                                {{ old('jenis_voucher', 'username_password') == 'username_password' ? 'selected' : '' }}>
                                Username = Password</option>
                            <option value="username_only"
                                {{ old('jenis_voucher') == 'username_only' ? 'selected' : '' }}>
                                Username + Password Terpisah</option>
                        </select>
                    </div>

                    {{-- Kode Kombinasi --}}
                    <div>
                        <label class="block font-medium mb-1">Kode Kombinasi</label>
                        <select name="kode_kombinasi" required
                            class="w-full border border-gray-500 rounded-lg px-3 py-2 shadow-sm focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-400 focus:shadow-lg transition duration-200">
                            <option value="Abcdefghjklmnp"
                                {{ old('kode_kombinasi', 'Abcdefghjklmnp') == 'Abcdefghjklmnp' ? 'selected' : '' }}>
                                Abcdefghjklmnp</option>
                            <option value="abcdefghjklmnp"
                                {{ old('kode_kombinasi') == 'abcdefghjklmnp' ? 'selected' : '' }}>
                                abcdefghjklmnp</option>
                            <option value="ABCDEFGHJKLMN"
                                {{ old('kode_kombinasi') == 'ABCDEFGHJKLMN' ? 'selected' : '' }}>
                                ABCDEFGHJKLMN</option>
                            <option value="aBcDefGhJKmn"
                                {{ old('kode_kombinasi') == 'aBcDefGhJKmn' ? 'selected' : '' }}>
                                aBcDefGhJKmn</option>
                        </select>
                    </div>

                    {{-- Prefix & Panjang Karakter --}}
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block font-medium mb-1">Prefix</label>
                            <input type="text" name="prefix" value="{{ old('prefix') }}" placeholder="Opsional"
                                class="w-full border border-gray-500 rounded-lg px-3 py-2 shadow-sm focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-400 focus:shadow-lg transition duration-200" />
                        </div>
                        <div>
                            <label class="block font-medium mb-1">Panjang Karakter</label>
                            <input type="number" name="panjang_karakter" value="{{ old('panjang_karakter', 6) }}"
                                min="4" max="20" required
                                class="w-full border border-gray-500 rounded-lg px-3 py-2 shadow-sm focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-400 focus:shadow-lg transition duration-200" />
                        </div>
                    </div>

                    {{-- Outlet --}}
                    <div>
                        <label class="block font-medium mb-1">Outlet</label>
                        <input type="text" name="outlet" value="{{ old('outlet', 'DEFAULT') }}"
                            class="w-full border border-gray-500 rounded-lg px-3 py-2 shadow-sm focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-400 focus:shadow-lg transition duration-200" />
                    </div>

                    {{-- Jumlah --}}
                    <div>
                        <label class="block font-medium mb-1">Jumlah Voucher <span class="text-red-500">*</span></label>
                        <input type="number" id="jumlah" name="jumlah" value="{{ old('jumlah', 10) }}"
                            min="1" max="1000" required
                            class="w-full border border-gray-500 rounded-lg px-3 py-2 shadow-sm focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-400 focus:shadow-lg transition duration-200" />
                        <p class="text-sm text-gray-500">Maksimal 1000 voucher per batch</p>
                    </div>
                </div>

                <!-- Preview Kanan -->
                <div class="md:col-span-4 space-y-5">
                    <div
                        class="bg-white p-6 rounded-2xl border border-blue-200 shadow-md hover:shadow-lg transition-all duration-300">
                        <h5 class="mb-4 text-lg font-bold text-blue-600 flex items-center gap-2">
                            <i class="fa-solid fa-receipt text-blue-500"></i>
                            Preview Harga
                        </h5>

                        <!-- Input Harga -->
                        <div class="space-y-4">
                            <div>
                                <label class="block font-semibold text-gray-700 mb-1">HPP (Per Voucher)</label>
                                <input type="number" id="hpp" name="hpp" readonly
                                    class="w-full bg-gray-100 border-2 border-gray-300 rounded-lg px-3 py-2 shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-300 transition-all duration-200" />
                            </div>

                            <div>
                                <label class="block font-semibold text-gray-700 mb-1">HJK (Per Voucher)</label>
                                <input type="number" id="hjk" name="hjk" readonly
                                    class="w-full bg-gray-100 border-2 border-gray-300 rounded-lg px-3 py-2 shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-300 transition-all duration-200" />
                            </div>

                            <div>
                                <label class="block font-semibold text-gray-700 mb-1">Komisi (Per Voucher)</label>
                                <input type="number" id="komisi" name="komisi" readonly
                                    class="w-full bg-gray-100 border-2 border-gray-300 rounded-lg px-3 py-2 shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-300 transition-all duration-200" />
                            </div>
                        </div>

                        <hr class="my-5 border-gray-300">

                        <!-- Total Preview -->
                        <div class="space-y-2 text-gray-800">
                            <div class="flex justify-between">
                                <span class="font-semibold text-blue-600">Total HPP:</span>
                                <span id="preview_total_hpp" class="font-medium">Rp 0</span>
                            </div>

                            <div class="flex justify-between">
                                <span class="font-semibold text-blue-600">Total Komisi:</span>
                                <span id="preview_total_komisi" class="font-medium">Rp 0</span>
                            </div>

                            <div class="flex justify-between text-lg">
                                <span class="font-bold text-blue-700">Total HJK:</span>
                                <span id="preview_total_hjk" class="font-bold text-blue-700">Rp 0</span>
                            </div>
                        </div>

                        <!-- Hidden Fields -->
                        <input type="hidden" id="total_hpp" name="total_hpp" value="0">
                        <input type="hidden" id="total_komisi" name="total_komisi" value="0">
                    </div>
                </div>

                <!-- Tombol -->
                <div class="md:col-span-12 flex gap-3 mt-6 justify-end">
                    <a href="{{ route('stokvoucher.index') }}"
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

    <script>
        function formatRupiah(amount) {
            return new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR',
                minimumFractionDigits: 0
            }).format(amount);
        }

        const resellerSelect = document.getElementById('reseller_id');
        const profileSelect = document.getElementById('profile_voucher_id');
        const routerInput = document.getElementById('router');
        const serverInput = document.getElementById('server');
        const hppInput = document.getElementById('hpp');
        const hjkInput = document.getElementById('hjk');
        const komisiInput = document.getElementById('komisi');
        const jumlahInput = document.getElementById('jumlah');

        function hitungTotal() {
            const jumlah = parseFloat(jumlahInput.value || 0);
            const hpp = parseFloat(hppInput.value || 0);
            const komisi = parseFloat(komisiInput.value || 0);
            const hjk = parseFloat(hjkInput.value || 0);

            const totalHpp = jumlah * hpp;
            const totalKomisi = jumlah * komisi;
            const totalHjk = jumlah * hjk;

            document.getElementById('total_hpp').value = totalHpp;
            document.getElementById('total_komisi').value = totalKomisi;

            document.getElementById('preview_total_hpp').textContent = formatRupiah(totalHpp);
            document.getElementById('preview_total_komisi').textContent = formatRupiah(totalKomisi);
            document.getElementById('preview_total_hjk').textContent = formatRupiah(totalHjk);
        }

        resellerSelect.addEventListener('change', function() {
            const selected = this.options[this.selectedIndex];
            routerInput.value = selected.dataset.router || '';
            serverInput.value = selected.dataset.server || '';

            if (selected.text.toUpperCase().includes('SYSTEM')) {
                komisiInput.value = 0;
            }
            hitungTotal();
        });

        profileSelect.addEventListener('change', function() {
            const selected = this.options[this.selectedIndex];
            hppInput.value = selected.dataset.hpp || 0;
            hjkInput.value = selected.dataset.hjk || 0;
            komisiInput.value = selected.dataset.komisi || 0;
            hitungTotal();
        });

        jumlahInput.addEventListener('input', hitungTotal);

        document.addEventListener('DOMContentLoaded', function() {
            if (profileSelect.value) profileSelect.dispatchEvent(new Event('change'));
            if (resellerSelect.value) resellerSelect.dispatchEvent(new Event('change'));
            hitungTotal();
        });

        document.getElementById('voucherForm').addEventListener('submit', function(e) {
            const submitBtn = document.getElementById('submitBtn');
            const submitText = document.getElementById('submitText');
            const submitSpinner = document.getElementById('submitSpinner');

            const requiredFields = ['profile_voucher_id', 'jumlah', 'jenis_voucher', 'kode_kombinasi'];
            let isValid = true;

            requiredFields.forEach(fieldName => {
                const field = document.querySelector(`[name="${fieldName}"]`);
                if (!field.value) {
                    isValid = false;
                    field.focus();
                }
            });

            if (!isValid) {
                e.preventDefault();
                alert('Mohon lengkapi semua field yang wajib diisi');
                return;
            }

            const hpp = parseFloat(hppInput.value || 0);
            const jumlah = parseInt(jumlahInput.value || 0);

            if (hpp <= 0) {
                e.preventDefault();
                alert('Pilih profile dengan HPP yang valid');
                profileSelect.focus();
                return;
            }
            if (jumlah <= 0 || jumlah > 1000) {
                e.preventDefault();
                alert('Jumlah voucher harus antara 1-1000');
                jumlahInput.focus();
                return;
            }

            submitBtn.disabled = true;
            submitText.textContent = 'Membuat Voucher...';
            submitSpinner.classList.remove('hidden');
        });

        document.querySelector('button[type="reset"]').addEventListener('click', function() {
            setTimeout(() => {
                routerInput.value = '';
                serverInput.value = '';
                hppInput.value = 0;
                hjkInput.value = 0;
                komisiInput.value = 0;
                jumlahInput.value = 10;
                hitungTotal();
            }, 100);
        });
    </script>

</body>

</html>
