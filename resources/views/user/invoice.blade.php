<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Daftar Invoice - BNC Cloud Manager</title>

    <!-- Tailwind -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- jQuery & DataTables -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="{{ asset('css/datatable.css') }}">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

</head>

<body class="bg-gray-50 flex min-h-screen">

    <!-- Sidebar -->
    @include('layouts.sidebar')

    <main class="md:pl-72 pt-20 w-full p-6">

        <!-- Header -->
        <div class="flex items-center mb-8">
            <h2 class="text-4xl font-extrabold tracking-tight text-blue-500 flex items-center">
                <i class="fa-solid fa-file-invoice w-8 h-8 mr-4 text-blue-500"></i>
                Daftar Invoice
            </h2>
        </div>

        <div class="bg-white rounded-2xl shadow-lg border border-blue-200 border-t-4 border-t-blue-400 p-6">

            <!-- Loading Spinner -->
            <div id="loading" class="flex justify-center items-center py-10">
                <div class="w-10 h-10 border-4 border-blue-400 border-t-transparent rounded-full animate-spin">
                </div>
            </div>

            <!-- Table Container -->
            <div id="tableContainer" class="hidden bg-white shadow-lg rounded-2xl p-6 overflow-x-auto">
                <table id="invoiceTable" class="display w-full">
                    <thead>
                        <tr>
                            <th>Perusahaan & Subdomain</th>
                            <th>Paket</th>
                            <th>Siklus</th>
                            <th>Harga</th>
                            <th>Status</th>
                            <th>Invoice</th>
                        </tr>
                    </thead>
                    <tbody id="invoice-table-body">
                        <tr>
                            <td colspan="6" class="text-center text-gray-400">Memuat data...</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </main>

    <!-- Modal Pembayaran -->
    <div id="paymentModal"
        class="fixed inset-0 bg-black/50 hidden items-center justify-center z-50 transition-all duration-300 ease-out">
        <div class="bg-white rounded-2xl shadow-2xl p-6 w-[90%] max-w-md text-center transform scale-95 opacity-0 transition-all duration-300"
            id="paymentBox">
            <h3 class="text-xl font-bold text-blue-600 mb-4">Panduan Pembayaran</h3>
            <p class="text-gray-700 mb-3">Silakan transfer ke rekening berikut:</p>

            <div class="bg-blue-50 border border-blue-200 rounded-xl py-3 mb-4">
                <p class="text-sm text-gray-800 leading-relaxed">
                    💳 <strong>BCA 123456789</strong><br>
                    a.n. <strong>PT Borneo Network Center</strong>
                </p>
            </div>

            <p class="text-gray-700 mb-3">Setelah transfer, kirim bukti pembayaran ke WhatsApp:</p>

            <a href="https://wa.me/6281528297789"
            target="_blank"
            class="inline-flex items-center justify-center bg-gradient-to-r from-green-500 to-emerald-600 text-white font-semibold px-5 py-2.5 rounded-full shadow-md hover:from-green-600 hover:to-emerald-700 transform hover:scale-105 transition-all duration-300 mb-4">
                <i class="fab fa-whatsapp mr-2 text-lg"></i>Kirim Bukti Pembayaran
            </a>

            <p class="text-sm text-gray-500 mb-4">
                Setelah bukti dikirim, tunggu admin mengonfirmasi pembayaranmu.
            </p>

            <button id="closeModal"
                class="bg-gray-200 text-gray-700 px-4 py-2 rounded-full hover:bg-gray-300 hover:scale-105 transition-all duration-200">
                Tutup
            </button>
        </div>
    </div>



    <script>
document.addEventListener('DOMContentLoaded', function () {

    const tbody = document.getElementById('invoice-table-body');
    const SUBDOMAIN_SUFFIX = '.bncradius.id';

    function getStatusBadgeClass(status) {
        status = status ? status.toLowerCase() : '';
        return status === 'dibayar'
            ? 'bg-green-100 text-green-700'
            : 'bg-red-100 text-red-700';
    }

    fetch("{{ route('subscription.user.json') }}")
        .then(res => res.json())
        .then(data => {

            // Clear tbody
            tbody.innerHTML = '';

            data.forEach((sub, index) => {
                const tr = document.createElement('tr');
                tr.className = index % 2 === 0
                    ? 'bg-white hover:bg-gray-50 transition'
                    : 'bg-gray-50 hover:bg-gray-100 transition';

                const subdomainBase = sub.subdomain_url || sub.subdomain || '-';
                const fullSubdomain = subdomainBase !== '-' ? subdomainBase + SUBDOMAIN_SUFFIX : '-';
                const formattedSiklus = sub.siklus ? sub.siklus.charAt(0).toUpperCase() + sub.siklus.slice(1) : '-';
                const formattedStatus = sub.status ? sub.status.charAt(0).toUpperCase() + sub.status.slice(1) : 'Unknown';
                const badgeClass = getStatusBadgeClass(sub.status);
                const formattedHarga = Number(sub.harga || 0).toLocaleString('id-ID');

                tr.innerHTML = `
                    <td class="px-6 py-4">${sub.nama_perusahaan || '-'}<br>
                        <span class="text-xs text-indigo-500">${fullSubdomain}</span>
                    </td>
                    <td class="px-6 py-4">${sub.paket?.nama || sub.nama_paket || '-'}</td>
                    <td class="px-6 py-4 text-center">${formattedSiklus}</td>
                    <td class="px-6 py-4 font-semibold">Rp ${formattedHarga}</td>
                    <td class="px-6 py-4 text-center">
                        <span class="px-3 py-1 rounded-full text-xs font-semibold ${badgeClass}">
                            ${formattedStatus}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-center">
    ${
        sub.invoice?.file_path
            ? `<a href="/storage/${sub.invoice.file_path}" target="_blank"
                class="inline-flex items-center bg-indigo-600 text-white px-3 py-1 text-xs rounded-full shadow-sm hover:bg-indigo-700 hover:shadow-md transition-all duration-200">
                <i class="fas fa-download mr-1"></i>Download
              </a>`
            : `<button onclick="openPaymentModal()"
                class="inline-flex items-center bg-blue-500 text-white px-3 py-1 text-xs rounded-full shadow-sm hover:bg-blue-600 hover:shadow-md transform hover:scale-105 transition-all duration-200">
                </i>Petunjuk pembayaran
              </button>`
    }
</td>

                `;
                tbody.appendChild(tr);
            });

            // ✅ Init DataTable hanya sekali
            if (!$.fn.DataTable.isDataTable('#invoiceTable')) {
                $('#invoiceTable').DataTable({
                    responsive: true,
                    ordering: false,
                    language: {
                        url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/id.json'
                    },
                    initComplete: function () {
                        $('#loading').hide();
                        $('#tableContainer').removeClass('hidden').hide().fadeIn(200);
                    }
                });
            }

        })
        .catch(err => {
            console.error('Error fetching invoices:', err);
            tbody.innerHTML = `<tr><td colspan="6" class="text-center text-red-500">
                Gagal memuat data. Silakan coba lagi.
            </td></tr>`;
            $('#loading').hide();
            $('#tableContainer').removeClass('hidden');
        });
});

// Modal handler
function openPaymentModal() {
    document.getElementById('paymentModal').classList.remove('hidden');
    document.getElementById('paymentModal').classList.add('flex');
}

document.getElementById('closeModal').addEventListener('click', () => {
    const modal = document.getElementById('paymentModal');
    modal.classList.add('hidden');
    modal.classList.remove('flex');
});

function openPaymentModal() {
    const modal = document.getElementById('paymentModal');
    const box = document.getElementById('paymentBox');
    modal.classList.remove('hidden');
    modal.classList.add('flex');
    setTimeout(() => {
        box.classList.remove('scale-95', 'opacity-0');
        box.classList.add('scale-100', 'opacity-100');
    }, 10);
}

document.getElementById('closeModal').addEventListener('click', () => {
    const modal = document.getElementById('paymentModal');
    const box = document.getElementById('paymentBox');
    box.classList.add('scale-95', 'opacity-0');
    setTimeout(() => {
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }, 200);
});



    </script>

</body>

</html>
