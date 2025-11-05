<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Instances - BNC CLOUD MANAGER</title>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        .sidebar-gradient {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        .card-hover {
            transition: all 0.3s ease;
        }

        .card-hover:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }

        .menu-item {
            transition: all 0.3s ease;
        }

        .menu-item:hover {
            background: rgba(255, 255, 255, 0.1);
            transform: translateX(5px);
        }
    </style>
</head>

<body class="bg-gray-50 flex min-h-screen">

    <!-- Sidebar -->
    @include('layouts.sidebar')

    <main class="md:pl-72 pt-20 w-full p-8">
            <div class="mb-8">
                <header class="flex items-center justify-center gap-4 mb-14 border-b pb-6 border-blue-200">
                    <!-- Logo -->
                    <div
                        class="w-14 h-14 bg-gradient-to-br from-blue-400 to-blue-600 flex items-center justify-center rounded-2xl shadow-md">
                        <i class="fa-solid fa-tags text-white text-2xl"></i>
                    </div>

                    <!-- Judul -->
                    <div class="text-center sm:text-left">
                        <h2 class="text-4xl font-bold text-blue-600">Harga Berlangganan</h2>
                        <p class="text-lg text-gray-600">Pilih paket yang sesuai dengan kebutuhan bisnis Anda</p>
                    </div>
                </header>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    @foreach ($pakets as $paket)
                        <div
                            class="bg-white rounded-2xl shadow-md hover:shadow-xl hover:-translate-y-1 transition-all p-8 flex flex-col justify-between border-2 border-blue-600">
                            <div>
                                <h3 class="text-xl font-bold text-blue-600 mb-2 text-center">BNC CLOUD
                                    {{ strtoupper($paket->nama) }}</h3>
                                <div class="text-center text-3xl font-extrabold text-blue-600 mb-4 break-words">
                                    <sup
                                        class="text-base font-medium">Rp</sup>{{ number_format($paket->harga_bulanan, 0, ',', '.') }}
                                    <span class="text-base font-normal"> / bln</span>
                                </div>
                                <img src="https://cdn-icons-png.flaticon.com/512/2082/2082812.png"
                                    class="w-20 mx-auto mb-6" alt="Cloud Icon">
                                <ul class="text-gray-700 space-y-3 mb-6 text-sm">
                                    <li class="flex items-center justify-center"><i
                                            class="fa fa-check text-green-500 mt-1 mr-2"></i> {{ $paket->mikrotik }}
                                        Router MikroTik</li>
                                    <li class="flex items-center justify-center"><i
                                            class="fa fa-check text-green-500 mt-1 mr-2"></i>
                                        {{ number_format($paket->langganan, 0, ',', '.') }} Langganan</li>
                                    <li class="flex items-center justify-center"><i
                                            class="fa fa-check text-green-500 mt-1 mr-2"></i>
                                        {{ number_format($paket->voucher, 0, ',', '.') }} Voucher</li>
                                    <li class="flex items-center justify-center"><i
                                            class="fa fa-check text-green-500 mt-1 mr-2"></i> <span
                                            class="font-semibold text-red-500">{{ number_format($paket->user_online, 0, ',', '.') }}
                                            User Online</span></li>

                                    @php
                                        $fiturTambahan = [
                                            'vpn_tunnel' => 'Free VPN Radius',
                                            'vpn_remote' => 'Free VPN Remote',
                                            'whatsapp_gateway' => 'WhatsApp notifikasi',
                                            'payment_gateway' => 'Payment Gateway',
                                            'client_area' => 'Aplikasi client area',
                                            'custom_domain' => 'Custom Domain',
                                        ];
                                    @endphp

                                    @foreach ($fiturTambahan as $key => $label)
                                        <li class="flex items-center justify-center">
                                            <i
                                                class="{{ $paket->$key ? 'fa fa-check text-green-500' : 'fa fa-times text-gray-400' }} mt-1 mr-2"></i>
                                            <span
                                                class="{{ $paket->$key ? '' : 'text-gray-400 line-through' }}">{{ $label }}</span>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                            <div class="text-center text-sm mb-4">
                                <p class="text-gray-400 line-through">
                                    Rp{{ number_format((int) $paket->harga_bulanan * 12, 0, ',', '.') }} / 12 Bln</p>
                                <p class="text-green-600 font-bold">
                                    Rp{{ number_format($paket->harga_tahunan, 0, ',', '.') }} / 12 Bln</p>
                            </div>
                            <a href="{{ route('subscription.create', ['paket_id' => $paket->id]) }}"
                                class="block w-full text-center px-4 py-3 rounded-lg border border-blue-600 text-blue-600 hover:bg-blue-50 font-semibold transition">
                                Berlangganan
                            </a>

                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    </main>

</body>

</html>
