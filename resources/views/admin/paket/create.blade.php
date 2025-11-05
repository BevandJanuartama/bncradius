<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Tambah Paket - BNC CLOUD MANAGER</title>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-50 flex min-h-screen">

    <!-- Sidebar -->
    @include('layouts.adminbar')

    <!-- Main Content -->
    <main class="md:pl-72 pt-20 w-full p-6">
        <div class="flex items-center mb-8">
            <h2
                class="text-4xl font-extrabold tracking-tight text-blue-500 flex items-center">
                <i class="fa-solid fa-circle-plus w-8 h-8 mr-5 text-blue-500"></i>
                Tambah Paket
            </h2>
        </div>

        <div class="bg-white rounded-xl shadow-md border border-blue-200 border-t-4 border-t-blue-400 p-6">
            <form action="{{ route('paket.store') }}" method="POST" class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @csrf

                <div>
                    <label class="block font-medium mb-1">Nama Paket</label>
                    <input type="text" name="nama" value="{{ old('nama') }}"
                        class="w-full border border-gray-500 rounded-lg px-3 py-2 shadow-sm focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-400 focus:shadow-lg transition duration-200" />
                </div>

                <div>
                    <label class="block font-medium mb-1">Harga Bulanan</label>
                    <input type="number" name="harga_bulanan" value="{{ old('harga_bulanan') }}"
                        class="w-full border border-gray-500 rounded-lg px-3 py-2 shadow-sm focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-400 focus:shadow-lg transition duration-200" />
                </div>

                <div>
                    <label class="block font-medium mb-1">Harga Tahunan</label>
                    <input type="number" name="harga_tahunan" value="{{ old('harga_tahunan') }}"
                        class="w-full border border-gray-500 rounded-lg px-3 py-2 shadow-sm focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-400 focus:shadow-lg transition duration-200" />
                </div>

                <div>
                    <label class="block font-medium mb-1">Mikrotik</label>
                    <input type="number" name="mikrotik" value="{{ old('mikrotik') }}"
                        class="w-full border border-gray-500 rounded-lg px-3 py-2 shadow-sm focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-400 focus:shadow-lg transition duration-200" />
                </div>

                <div>
                    <label class="block font-medium mb-1">Langganan</label>
                    <input type="number" name="langganan" value="{{ old('langganan') }}"
                        class="w-full border border-gray-500 rounded-lg px-3 py-2 shadow-sm focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-400 focus:shadow-lg transition duration-200" />
                </div>

                <div>
                    <label class="block font-medium mb-1">Voucher</label>
                    <input type="number" name="voucher" value="{{ old('voucher') }}"
                        class="w-full border border-gray-500 rounded-lg px-3 py-2 shadow-sm focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-400 focus:shadow-lg transition duration-200" />
                </div>

                <div>
                    <label class="block font-medium mb-1">User Online</label>
                    <input type="number" name="user_online" value="{{ old('user_online') }}"
                        class="w-full border border-gray-500 rounded-lg px-3 py-2 shadow-sm focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-400 focus:shadow-lg transition duration-200" />
                </div>

                <!-- Checkbox Section -->
                <div class="md:col-span-2 mt-4">
                    <h3 class="text-lg font-semibold mb-2 text-gray-700">Fitur Tambahan</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3">
                        @php
                            $checkboxes = [
                                'vpn_tunnel' => 'VPN Tunnel',
                                'vpn_remote' => 'VPN Remote',
                                'whatsapp_gateway' => 'WhatsApp Gateway',
                                'payment_gateway' => 'Payment Gateway',
                                'custom_domain' => 'Custom Domain',
                                'client_area' => 'Client Area',
                            ];
                        @endphp

                        @foreach ($checkboxes as $key => $label)
                            <label
                                class="inline-flex items-center space-x-2 bg-gray-50 border border-gray-300 rounded-md px-3 py-2 hover:bg-gray-100 transition">
                                <input type="checkbox" name="{{ $key }}" value="1"
                                    {{ old($key) ? 'checked' : '' }} class="accent-blue-500 w-5 h-5">
                                <span class="text-gray-700">{{ $label }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>
                <!-- Buttons -->
                <div class="md:col-span-2 flex gap-3 mt-6 justify-end">
                    <a href="{{ route('paket.index') }}"
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
