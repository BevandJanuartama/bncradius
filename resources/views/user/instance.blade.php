<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Instances - BNC CLOUD MANAGER</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        .sidebar-gradient {
            background: linear-gradient(135deg, #549BE7 0%, #3B82F6 100%);
        }
        /* Custom Hover Effect */
        .card-hover {
            transition: all 0.3s ease;
            border-left: 5px solid #549BE7; /* Garis branding di sisi kiri */
        }
        .card-hover:hover {
            transform: translateY(-5px);
            /* Box shadow lebih elegan */
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
            border-color: #3B82F6; /* Ubah warna border saat hover */
        }
        /* Style lainnya tetap sama */
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

    @include('layouts.sidebar')


    <main class="md:pl-72 pt-20 w-full p-8">
        <div class="mb-8">
            <header class="flex items-center justify-center gap-4 mb-14 border-b pb-6 border-blue-200">
                <!-- Logo -->
                <div
                    class="w-14 h-14 bg-gradient-to-br from-blue-400 to-blue-600 flex items-center justify-center rounded-2xl shadow-md">
                    <i class="fa-solid fa-cloud text-white text-2xl"></i>
                </div>

                <!-- Judul -->
                <div class="text-center sm:text-left">
                    <h2 class="text-4xl font-bold text-blue-600">Instance Saya</h2>
                    <p class="text-gray-600 mt-1">Kelola dan pantau semua instance yang Anda miliki.</p>
                </div>
            </header>
        </div>

        <div class="bg-white rounded-xl shadow-md p-6 mb-8">
            <div class="flex justify-between items-center">
                <h3 class="text-xl font-semibold text-gray-700">Kelola Instance</h3>
                <a href="/order" class="inline-flex items-center px-5 py-2 bg-blue-500 text-white text-sm font-semibold rounded-lg hover:bg-blue-600 transition-all">
                    <i class="fas fa-plus-circle mr-2"></i> Tambah Instance
                </a>
            </div>
        </div>

        <div id="card-container" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <p class="text-gray-400 col-span-full text-center" id="loading-text">
                <i class="fas fa-spinner fa-spin mr-2"></i> Memuat data...
            </p>
        </div>

    </main>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const container = document.getElementById('card-container');

    // --- Helper function untuk memformat tanggal ---
    function formatCreatedAt(dateString) {
        if (!dateString) return '-';
        try {
            const options = { year: 'numeric', month: 'short', day: 'numeric', hour: '2-digit', minute: '2-digit' };
            // Menggunakan 'id-ID' untuk format tanggal Indonesia
            return new Date(dateString).toLocaleDateString('id-ID', options);
        } catch (e) {
            return dateString; // Fallback jika gagal format
        }
    }

    // --- Status Logic (Kept as per your previous request) ---
    function getStatusBadgeClass(status) {
        status = status ? status.toLowerCase() : '';
        if (status === 'dibayar') {
            return 'bg-green-100 text-green-700 ring-1 ring-green-300';
        } else if (status === 'pending' || status === 'menunggu') {
            return 'bg-yellow-100 text-yellow-700 ring-1 ring-yellow-300';
        } else {
            return 'bg-red-100 text-red-700 ring-1 ring-red-300';
        }
    }

    // --- STATIC ICON HTML ---
    const STATIC_ICON_HTML = `
        <img src="https://cdn-icons-png.flaticon.com/512/3598/3598209.png" class="w-12 h-12 mb-3 mx-auto" alt="Instance Icon" />
    `;
    // -----------------------------------------------------------


    fetch("{{ route('subscription.user.json') }}")
        .then(res => res.json())
        .then(data => {
            container.innerHTML = '';

            if (data.length === 0) {
                container.innerHTML = '<p class="text-center text-gray-500 col-span-full italic py-6">Tidak ada instance aktif.</p>';
                return;
            }

            data.forEach(sub => {
                const fullSubdomain = sub.subdomain_url ? sub.subdomain_url + '.bncradius.id' : '-';
                const statusClass = getStatusBadgeClass(sub.status);
                const harga = Number(sub.harga).toLocaleString('id-ID');
                const formattedStatus = sub.status?.charAt(0).toUpperCase() + sub.status?.slice(1) || 'Unknown';
                const formattedSiklus = sub.siklus?.charAt(0).toUpperCase() + sub.siklus?.slice(1) || '-';
                const formattedCreatedAt = formatCreatedAt(sub.created_at); // FORMAT BARU

                const card = document.createElement('div');
                card.className = 'bg-white rounded-xl shadow-lg p-6 card-hover flex flex-col justify-between space-y-4';

                // --- CARD CONTENT: SUSUNAN DENGAN CREATED_AT ---
                card.innerHTML = `
                    <div class="text-center border-b pb-4 border-gray-100">
                        ${STATIC_ICON_HTML}
                        <h3 class="text-xl font-bold text-gray-900">${sub.nama_perusahaan || 'Perusahaan Tanpa Nama'}</h3>
                    </div>

                    <div class="space-y-2 text-sm flex-grow">
                        <div class="flex justify-between items-center border-b border-dashed pb-1">
                            <span class="font-medium text-gray-500"><i class="fas fa-globe mr-2 text-blue-400"></i> Subdomain</span>
                            <a href="http://${fullSubdomain}" target="_blank" class="font-semibold text-blue-600 hover:text-blue-800 transition-colors">${fullSubdomain}</a>
                        </div>

                        <div class="flex justify-between items-center border-b border-dashed pb-1">
                            <span class="font-medium text-gray-500"><i class="fas fa-hdd mr-2 text-blue-400"></i> Data Center</span>
                            <span class="font-semibold text-gray-800">${sub.data_center || '-'}</span>
                        </div>

                        <div class="flex justify-between items-center border-b border-dashed pb-1">
                            <span class="font-medium text-gray-500"><i class="fas fa-box-open mr-2 text-blue-400"></i> Paket</span>
                            <span class="font-semibold text-gray-800">${sub.paket?.nama || sub.nama_paket || '-'}</span>
                        </div>

                        <div class="flex justify-between items-center border-b border-dashed pb-1">
                            <span class="font-medium text-gray-500"><i class="fas fa-redo-alt mr-2 text-blue-400"></i> Siklus</span>
                            <span class="font-semibold text-gray-800">${formattedSiklus}</span>
                        </div>

                        <div class="flex justify-between items-center border-b border-dashed pb-1">
                            <span class="font-medium text-gray-500"><i class="fas fa-dollar-sign mr-2 text-blue-400"></i> Harga</span>
                            <span class="text-base font-extrabold text-blue-600">Rp ${harga}</span>
                        </div>

                        <div class="flex justify-between items-center pt-2">
                            <span class="font-medium text-gray-500"><i class="fas fa-calendar-alt mr-2 text-blue-400"></i> Dibuat Pada</span>
                            <span class="font-semibold text-gray-700">${formattedCreatedAt}</span>
                        </div>
                    </div>

                    <div class="mt-4 pt-4 border-t border-gray-100 flex flex-col space-y-3">
                        <div class="flex justify-between items-center">
                            <span class="font-medium text-gray-500">Status Pembayaran:</span>
                            <span class="px-3 py-1 inline-flex text-xs leading-5 font-bold uppercase rounded-full ${statusClass} shadow-sm">
                                ${formattedStatus}
                            </span>
                        </div>
                    </div>
                `;
                // --- END CARD CONTENT ---

                container.appendChild(card);
            });
        })
        .catch(err => {
            console.error('Error fetching data:', err);
            container.innerHTML = '<p class="text-center text-red-500 col-span-full py-6"><i class="fas fa-exclamation-circle mr-2"></i> Gagal memuat data.</p>';
        });
});
</script>

</body>
</html>
