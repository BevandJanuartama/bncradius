<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Subadmin</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="{{ asset('css/popup.css') }}">
    <style>
        /* ==== UTAMA: Warna Biru Baru ==== */
        .primary-gradient-bg {
            background: linear-gradient(to top, #549BE7, #3B82F6) !important;
        }

        .primary-gradient-text {
            color: #3B82F6 !important;
        }

        .btn-gradient {
            background: linear-gradient(to right, #549BE7, #3B82F6) !important;
            transition: all 0.3s ease;
        }

        /* ==== Efek dan Border ==== */
        .form-container {
            background: #fff;
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(59, 130, 246, 0.3);
            border: 1px solid rgba(59, 130, 246, 0.2);
            animation: fadeIn 0.8s ease-in-out;
        }

        .form-container h2 {
            color: #3B82F6 !important;
        }

        input,
        select {
            border: 2px solid rgba(59, 130, 246, 0.2);
            transition: all 0.3s ease;
        }

        input:focus,
        select:focus {
            border-color: #3B82F6;
            box-shadow: 0 0 15px rgba(59, 130, 246, 0.3);
            outline: none;
        }

        .btn-gradient:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(59, 130, 246, 0.4);
        }

        .icon-gradient {
            color: #3B82F6 !important;
        }

        .success-message {
            background: linear-gradient(to right, #10b981 0%, #059669 100%);
            color: white;
            padding: 15px;
            border-radius: 12px;
            margin-bottom: 20px;
            text-align: center;
            box-shadow: 0 8px 20px rgba(16, 185, 129, 0.3);
        }

        .error-list {
            background: rgba(252, 165, 165, 0.1);
            border: 2px solid rgba(252, 165, 165, 0.5);
            color: #ef4444;
            padding: 15px;
            border-radius: 12px;
            margin-bottom: 20px;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>

<body class="bg-gray-50">

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

        <div class="mb-6">
            <h2 class="text-4xl font-extrabold tracking-tight text-blue-500 flex items-center">
                <i class="fas fa-users w-8 h-8 mr-5 text-blue-500"></i>
                Kelola Subadmin
            </h2>
            <p class="text-gray-600 mt-1 sm:block ml-14">Kelola akses administrator sistem</p>
        </div>

        <div class="mb-6 flex justify-end">
            <button id="openAddSubadminModal" onclick="openAddSubadminModal()"
                class="bg-blue-500 text-white font-semibold py-2 px-4 rounded-lg flex items-center space-x-2 text-base hover:bg-blue-600 transition duration-300 shadow-md shadow-blue-500/40">
                <i class="fas fa-user-plus"></i>
                <span>Tambah Subadmin</span>
            </button>
        </div>

        @if (session('success'))
            <div class="success-message flex items-center">
                <i class="fas fa-check-circle mr-3"></i>
                {{ session('success') }}
            </div>
        @endif

        {{-- Bagian Daftar Subadmin (Tabel) --}}
        <div class="md:ml-0 p-0">
            <div class="bg-white shadow-xl rounded-2xl border border-gray-200 overflow-hidden">
                <div class="primary-gradient-bg px-6 py-4">
                    <div class="flex items-center justify-between">
                        <h3 class="text-xl font-bold text-white flex items-center">
                            <i class="fas fa-users-cog mr-3"></i>
                            Daftar Subadmin Aktif
                        </h3>
                        <div class="text-white text-sm">
                            <i class="fas fa-database mr-1"></i>
                            Total: <span class="font-bold">{{ $users->count() ?? 0 }}</span>
                        </div>
                    </div>
                </div>

                <div class="bg-gray-50 px-6 py-4 border-b">
                    <div
                        class="flex flex-col md:flex-row md:items-center md:justify-between space-y-3 md:space-y-0">
                        <div class="flex items-center space-x-2">
                            <div class="relative">
                                <i
                                    class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                                <input type="text" id="searchUser" placeholder="Cari nama atau telepon..."
                                    class="pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-600 focus:border-blue-600 w-64">
                            </div>
                        </div>

                        <div class="flex items-center space-x-3">
                            <label class="text-gray-700 font-medium">Filter Level:</label>
                            <select id="filterLevel"
                                class="px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-600">
                                <option value="">Semua Level</option>
                                <option value="administrator"> Administrator</option>
                                <option value="keuangan"> Keuangan</option>
                                <option value="teknisi"> Teknisi</option>
                                <option value="operator"> Operator</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-100 border-b-2 border-gray-200">
                            <tr>
                                <th
                                    class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    <i class="fas fa-hashtag mr-1"></i> No
                                </th>
                                <th
                                    class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    <i class="fas fa-user mr-1"></i> Nama
                                </th>
                                <th
                                    class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    <i class="fas fa-phone mr-1"></i> Telepon
                                </th>
                                <th
                                    class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    <i class="fas fa-user-shield mr-1"></i> Level
                                </th>
                                <th
                                    class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    <i class="fas fa-calendar mr-1"></i> Dibuat
                                </th>
                                <th
                                    class="px-6 py-4 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    <i class="fas fa-cogs mr-1"></i> Aksi
                                </th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200" id="userTableBody">
                            @forelse($users ?? [] as $index => $user)
                                <tr class="hover:bg-gray-50 transition-colors duration-200"
                                    data-level="{{ $user->level }}">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 font-medium">
                                        {{ $index + 1 }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div
                                                class="w-8 h-8 primary-gradient-bg rounded-full flex items-center justify-center text-white font-bold text-sm mr-3">
                                                {{ strtoupper(substr($user->name, 0, 1)) }}
                                            </div>
                                            <span class="text-sm font-medium text-gray-900">{{ $user->name }}</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                        <i class="fas fa-phone text-gray-400 mr-1"></i>
                                        {{ $user->telepon }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if ($user->level == 'administrator')
                                            <span
                                                class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                 Administrator
                                            </span>
                                        @elseif($user->level == 'keuangan')
                                            <span
                                                class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                 Keuangan
                                            </span>
                                        @elseif($user->level == 'teknisi')
                                            <span
                                                class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                 Teknisi
                                            </span>
                                        @elseif($user->level == 'operator')
                                            <span
                                                class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                                 Operator
                                            </span>
                                        @else
                                            <span
                                                class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                                 User
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                        <i class="fas fa-calendar text-gray-400 mr-1"></i>
                                        {{ $user->created_at ? $user->created_at->format('d/m/Y H:i') : '-' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center">
                                        <div class="flex items-center justify-center space-x-2">
                                            <button
                                                class="primary-gradient-bg hover:opacity-90 text-white px-3 py-1 rounded-lg text-xs font-medium transition-colors duration-200 flex items-center space-x-1">
                                                <i class="fas fa-edit text-xs"></i>
                                                <span>Edit</span>
                                            </button>

                                            <button onclick="confirmDelete('{{ $user->name }}', {{ $user->id }})"
                                                class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded-lg text-xs font-medium transition-colors duration-200 flex items-center space-x-1">
                                                <i class="fas fa-trash text-xs"></i>
                                                <span>Hapus</span>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-12 text-center">
                                        <div class="flex flex-col items-center justify-center text-gray-500">
                                            <i class="fas fa-users text-4xl mb-4 text-gray-300"></i>
                                            <p class="text-lg font-medium">Belum ada data subadmin</p>
                                            <p class="text-sm">Klik tombol "Tambah Subadmin" untuk menambahkan</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if (isset($users) && method_exists($users, 'links'))
                    <div class="bg-gray-50 px-6 py-4 border-t">
                        {{ $users->links() }}
                    </div>
                @endif
            </div>
        </div>
    </main>


    <div id="createModal" class="popup-modal hidden">
        <div id="popupContent" class="popup-content form-container p-6 w-full max-w-lg">

            <div class="flex items-center mb-6">
                <div class="p-2 bg-blue-500 rounded-lg text-white mr-3">
                    <i class="fa-solid fa-user-plus text-xl"></i>
                </div>
                <h1 class="text-2xl font-bold text-gray-800 tracking-wide">Tambah Subadmin Baru</h1>
            </div>

            @if ($errors->any() && old('name'))
                <div class="error-list">
                    <div class="flex items-center mb-3">
                        <i class="fas fa-exclamation-triangle mr-2"></i>
                        <strong>Terjadi kesalahan:</strong>
                    </div>
                    <ul class="ml-6 space-y-1 list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('subadmin.store') }}" class="space-y-6">
                @csrf

                <div>
                    <label class="flex items-center text-gray-700 font-semibold mb-2">
                        <i class="fas fa-user mr-2 text-blue-600"></i> Nama Lengkap
                    </label>
                    <input type="text" name="name" value="{{ old('name') }}"
                        class="w-full px-4 py-3 rounded-xl border border-gray-300 bg-white focus:border-blue-600 focus:ring-1 focus:ring-blue-600 transition-all duration-300"
                        placeholder="Masukkan nama lengkap" required>
                    @error('name')
                        <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div>
                    <label class="flex items-center text-gray-700 font-semibold mb-2">
                        <i class="fas fa-phone mr-2 text-blue-600"></i> Nomor Telepon
                    </label>
                    <input type="text" name="telepon" value="{{ old('telepon') }}"
                        class="w-full px-4 py-3 rounded-xl border border-gray-300 bg-white focus:border-blue-600 focus:ring-1 focus:ring-blue-600 transition-all duration-300"
                        placeholder="Contoh: 081234567890" required>
                    @error('telepon')
                        <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div>
                    <label class="flex items-center text-gray-700 font-semibold mb-2">
                        <i class="fas fa-lock mr-2 text-blue-600"></i> Password
                    </label>
                    <input type="password" name="password"
                        class="w-full px-4 py-3 rounded-xl border border-gray-300 bg-white focus:border-blue-600 focus:ring-1 focus:ring-blue-600 transition-all duration-300"
                        placeholder="Minimal 8 karakter" required>
                    @error('password')
                        <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div>
                    <label class="flex items-center text-gray-700 font-semibold mb-2">
                        <i class="fas fa-lock mr-2 text-blue-600"></i> Konfirmasi Password
                    </label>
                    <input type="password" name="password_confirmation"
                        class="w-full px-4 py-3 rounded-xl border border-gray-300 bg-white focus:border-blue-600 focus:ring-1 focus:ring-blue-600 transition-all duration-300"
                        placeholder="Ulangi password" required>
                </div>

                <div>
                    <label class="flex items-center text-gray-700 font-semibold mb-2">
                        <i class="fas fa-user-shield mr-2 text-blue-600"></i> Level Akses
                    </label>
                    <select name="level"
                        class="w-full px-4 py-3 rounded-xl border border-gray-300 bg-white focus:border-blue-600 focus:ring-1 focus:ring-blue-600 transition-all duration-300 appearance-none pr-8"
                        required>
                        <option value="">-- Pilih Level Akses --</option>
                        <option value="administrator" {{ old('level') == 'administrator' ? 'selected' : '' }}>
                            Administrator</option>
                        <option value="keuangan" {{ old('level') == 'keuangan' ? 'selected' : '' }}> Keuangan
                        </option>
                        <option value="teknisi" {{ old('level') == 'teknisi' ? 'selected' : '' }}> Teknisi</option>
                        <option value="operator" {{ old('level') == 'operator' ? 'selected' : '' }}> Operator
                        </option>
                    </select>
                    @error('level')
                        <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="flex justify-end gap-3 mt-6">
                    <button type="submit"
                        class="flex justify-center items-center gap-2 btn-gradient text-white px-4 py-2 rounded-lg shadow-md transition-all duration-200">
                        <i class="fa-solid fa-floppy-disk"></i> Simpan
                    </button>

                    <button type="button" onclick="closeAddSubadminModal()"
                        class="flex justify-center items-center gap-2 bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded-lg shadow-md transition-all duration-200">
                        <i class="fa-solid fa-arrow-left"></i> Batal
                    </button>
                </div>
            </form>
        </div>
    </div>


    <div id="deleteModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden flex items-center justify-center">
        <div class="bg-white rounded-2xl p-6 max-w-md mx-4">
            <div class="text-center">
                <i class="fas fa-exclamation-triangle text-5xl text-red-500 mb-4"></i>
                <h3 class="text-xl font-bold text-gray-900 mb-2">Konfirmasi Hapus</h3>
                <p class="text-gray-600 mb-6">Apakah Anda yakin ingin menghapus user <strong
                        id="deleteUserName"></strong>?</p>

                <div class="flex space-x-3">
                    <button onclick="closeDeleteModal()"
                        class="flex-1 bg-gray-300 hover:bg-gray-400 text-gray-800 py-2 px-4 rounded-lg transition-colors">
                        Batal
                    </button>
                    <button onclick="executeDelete()"
                        class="flex-1 bg-red-500 hover:bg-red-600 text-white py-2 px-4 rounded-lg transition-colors">
                        Ya, Hapus
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        let deleteUserId = null;
        const createModal = document.getElementById('createModal'); // Ambil modal

        // Fungsi untuk membuka modal Tambah Subadmin
        function openAddSubadminModal() {
            createModal.classList.remove('hidden');
        }

        // Fungsi untuk menutup modal Tambah Subadmin
        function closeAddSubadminModal() {
            createModal.classList.add('hidden');
        }

        // *** FUNGSI UTAMA: TAMPILKAN MODAL JIKA ADA ERROR VALIDASI ***
        // Jika ada error ($errors->any()) DAN ada data input lama (old('name')) dari form ini, modal akan otomatis muncul.
        @if ($errors->any() && old('name'))
            document.addEventListener('DOMContentLoaded', function() {
                openAddSubadminModal();
            });
        @endif
        // -----------------------------------------------------------------

        // FUNGSI SEARCH & FILTER
        document.getElementById('searchUser').addEventListener('keyup', filterTable);
        document.getElementById('filterLevel').addEventListener('change', filterTable);

        function filterTable() {
            const searchTerm = document.getElementById('searchUser').value.toLowerCase();
            const filterLevel = document.getElementById('filterLevel').value;
            const rows = document.querySelectorAll('#userTableBody tr');

            rows.forEach(row => {
                // Selector untuk Nama (di dalam span di td:nth-child(2)) dan Telepon (td:nth-child(3))
                const nameElement = row.querySelector('td:nth-child(2) span');
                const phoneElement = row.querySelector('td:nth-child(3)');

                const name = nameElement ? nameElement.textContent.toLowerCase() : '';
                const phone = phoneElement ? phoneElement.textContent.toLowerCase() : '';
                const level = row.getAttribute('data-level');

                const matchesSearch = name.includes(searchTerm) || phone.includes(searchTerm);
                const matchesLevel = !filterLevel || level === filterLevel;

                if (matchesSearch && matchesLevel) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        }

        // FUNGSI DELETE MODAL
        function confirmDelete(userName, userId) {
            deleteUserId = userId;
            document.getElementById('deleteUserName').textContent = userName;
            document.getElementById('deleteModal').classList.remove('hidden');
        }

        function closeDeleteModal() {
            document.getElementById('deleteModal').classList.add('hidden');
            deleteUserId = null;
        }

        function executeDelete() {
            if (deleteUserId) {
                // Buat form untuk delete
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = '/admin/delete/' + deleteUserId; // **PASTIKAN ROUTE INI BENAR**

                // CSRF token
                const csrfToken = document.createElement('input');
                csrfToken.type = 'hidden';
                csrfToken.name = '_token';
                csrfToken.value = '{{ csrf_token() }}';

                // Method DELETE
                const methodField = document.createElement('input');
                methodField.type = 'hidden';
                methodField.name = '_method';
                methodField.value = 'DELETE';

                form.appendChild(csrfToken);
                form.appendChild(methodField);
                document.body.appendChild(form);
                form.submit();
            }
        }
    </script>
</body>

</html>