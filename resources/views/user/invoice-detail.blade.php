<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">
    <title>Invoice Detail - BNC Cloud Manager</title>

    <meta name="viewport" content="width=device-width, initial-scale=1.0" />


    <script src="https://cdn.tailwindcss.com"></script>


    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
        integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLMDJ8gADpI+TRkE2vKYH4xR/0HjX42eFwB+I+p/PzD3L9Z88S+6q8/I/P3sX0Q=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <style>
        /* CSS untuk tampilan di layar */
        table th {
            background: linear-gradient(to top, #549BE7, #3B82F6) !important;
            color: white !important;
            text-align: left;
            padding: 12px 16px;
            font-weight: 600;
        }

        /* REVISI UTAMA: CSS KHUSUS PRINT */
        @media print {
            /* Sembunyikan semua di body kecuali print-area */
            body > *:not(.print-area) {
                display: none !important;
            }

            /* Tampilkan Print Area di posisi absolute atas kiri */
            .print-area {
                display: block !important;
                position: absolute;
                top: 0;
                left: 0;
                width: 100%;
                padding: 20px;
                box-sizing: border-box;
                color: #000;
                font-family: Arial, sans-serif;
            }

            /* Style untuk tabel saat dicetak */
            .print-area table {
                border-collapse: collapse;
                width: 100%;
                margin-top: 15px;
            }
            .print-area th, .print-area td {
                border: 1px solid #000;
                padding: 8px;
                font-size: 10pt;
                text-align: left;
            }
            .print-area th {
                background-color: #eee;
                color: #000;
                font-weight: bold;
            }
            .text-right-print {
                text-align: right !important;
            }
            .no-border-print th, .no-border-print td {
                border: none !important;
                padding: 4px 8px !important;
            }
            .no-border-print .total-row td {
                border-top: 2px solid #000 !important;
                font-size: 11pt !important;
            }
        }
    </style>
</head>

<body class="bg-gray-50 font-sans flex min-h-screen">
    @include('layouts.sidebar')

    <main class="md:pl-72 pt-20 w-full p-6">

        <div class="flex justify-between items-center mb-8">
            <h2
                class="text-4xl font-extrabold tracking-tight text-blue-500 flex items-center">
                <i class="fa-solid fa-file-invoice w-8 h-8 mr-3 text-blue-500"></i>Detail Invoice
            </h2>
        </div>
            <button onclick="printInvoice()"
                class="bg-blue-500 hover:bg-blue-600 text-white px-5 py-2.5 rounded-xl flex items-center gap-2 font-semibold shadow-lg transition duration-150 ease-in-out mb-8">
                <i class="fa-solid fa-print w-5 h-5"></i> Cetak Invoice
            </button>
        </div>
        <div id="invoiceContent" class="bg-white rounded-2xl shadow-lg border border-blue-200 border-t-4 border-t-blue-400 p-6"">
            {{-- Konten Invoice Asli --}}
            <div class="flex flex-col md:flex-row justify-between mb-8 pb-4 border-b border-gray-200">
                <div class="mb-4 md:mb-0">
                    <p class="text-sm font-medium text-gray-500">Nomor Invoice</p>
                    <h2 class="text-3xl font-bold text-gray-800">
                        INV{{ str_pad($subscription->id, 3, '0', STR_PAD_LEFT) }}
                    </h2>
                    <div class="mt-2 text-sm text-gray-600">
                        <p>Tanggal Terbit: <span class="font-semibold">{{ $subscription->created_at->format('d/m/Y') }}</span></p>
                        <p>Jatuh Tempo: <span class="font-semibold text-red-500">{{ $subscription->created_at->copy()->addDay(7)->format('d/m/Y') }}</span></p>
                    </div>
                </div>
                <div class="flex items-center">
                    @if ($subscription->status === 'paid' && $subscription->updated_at)
                        <span class="bg-green-100 text-green-800 text-lg px-5 py-2.5 rounded-full font-bold shadow-md status-badge">
                            LUNAS - {{ $subscription->updated_at->format('d/m/Y') }}
                        </span>
                    @elseif($subscription->created_at->copy()->addDay(7)->isPast())
                        <span class="bg-red-100 text-red-800 text-lg px-5 py-2.5 rounded-full font-bold shadow-md status-badge">
                            KADALUARSA
                        </span>
                    @else
                        <span class="bg-yellow-100 text-yellow-800 text-lg px-5 py-2.5 rounded-full font-bold shadow-md status-badge">
                            BELUM LUNAS
                        </span>
                    @endif
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-10">
                <div class="p-6 rounded-lg border border-blue-200" id="senderInfo">
                    <h3 class="font-bold text-xl mb-3 text-blue-700 flex items-center"><i class="fa-solid fa-building mr-2"></i> Dari:</h3>
                    <p class="text-gray-800 font-bold text-base">BNC Cloud Manager</p>
                    <p class="text-sm text-gray-600">Jl. Palm Raya, Ruko No. 6, RT 50 RW 07</p>
                    <p class="text-sm text-gray-600">Guntung Manggis, Banjarbaru</p>
                    <p class="text-sm text-gray-600 font-medium">Telp: 082170824476</p>
                </div>
                <div class="p-6 rounded-lg border border-gray-200" id="recipientInfo">
                    <h3 class="font-bold text-xl mb-3 text-gray-700 flex items-center"><i class="fa-solid fa-user-tie mr-2"></i> Untuk:</h3>
                    <p class="text-gray-800 font-bold text-base">{{ $subscription->nama_perusahaan }}</p>
                    <p class="text-sm text-gray-600">{{ $subscription->alamat }}</p>
                    <p class="text-sm text-gray-600">{{ $subscription->kabupaten }} - {{ $subscription->provinsi }}</p>
                    <p class="text-sm text-gray-600 font-medium">Telp: {{ $subscription->telepon }}</p>
                </div>
            </div>

            <h3 class="text-2xl font-bold text-gray-700 mb-4 border-b pb-2">Rincian Tagihan</h3>
            <div class="overflow-x-auto shadow-lg rounded-xl mb-8">
                <table class="w-full border-collapse" id="itemTable">
                    <thead>
                        <tr>
                            <th class="px-4 py-3 rounded-tl-xl">Deskripsi</th>
                            <th class="px-4 py-3 text-right rounded-tr-xl">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="border-b hover:bg-gray-50 transition duration-100">
                            <td class="px-4 py-3 text-left font-medium text-gray-700">Biaya Layanan ({{ ucfirst($subscription->siklus) }})</td>
                            <td class="px-4 py-3 text-right-print text-right font-medium text-gray-700">Rp {{ number_format($subscription->harga, 0, ',', '.') }}</td>
                        </tr>
                        <tr class="border-b hover:bg-gray-50 transition duration-100">
                            <td class="px-4 py-3 text-left font-medium text-gray-700">Biaya Registrasi</td>
                            <td class="px-4 py-3 text-right-print text-right font-medium text-gray-700">Rp 0</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="flex justify-end">
                <div class="w-full md:w-1/2 lg:w-1/3">
                    <table class="w-full border-collapse" id="summaryTable">
                        <tbody>
                            <tr class="border-t border-gray-300">
                                <td class="px-4 py-2 text-left font-semibold text-gray-700">Subtotal:</td>
                                <td class="px-4 py-2 text-right-print text-right font-semibold text-gray-700">Rp {{ number_format($subscription->harga, 0, ',', '.') }}</td>
                            </tr>
                            <tr class="bg-blue-50 border-t-2 border-blue-400">
                                <td class="px-4 py-3 text-left font-bold text-xl text-blue-700">Total Tagihan:</td>
                                <td class="px-4 py-3 text-right-print text-right font-bold text-xl text-blue-700">Rp {{ number_format($subscription->harga, 0, ',', '.') }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </main>

    {{-- KONTEN CETAK TERSEMBUNYI (REVISI) --}}
    <div id="printArea" class="print-area hidden"></div>

    <script>
        function printInvoice() {
            // Ambil data penting dari elemen HTML
            const invoiceNumber = document.querySelector('h2.text-3xl.font-bold.text-gray-800').textContent.trim();
            const issueDate = document.querySelector('p:nth-child(1) .font-semibold').textContent.trim();
            const dueDate = document.querySelector('p:nth-child(2) .font-semibold').textContent.trim();
            const statusText = document.querySelector('.status-badge').textContent.trim();

            const sender = document.getElementById('senderInfo').innerHTML;
            const recipient = document.getElementById('recipientInfo').innerHTML;

            const itemRows = Array.from(document.querySelectorAll('#itemTable tbody tr'))
                .map(row => {
                    const desc = row.cells[0].textContent.trim();
                    const total = row.cells[1].textContent.trim();
                    return `
                        <tr>
                            <td>${desc}</td>
                            <td class="text-right-print">${total}</td>
                        </tr>
                    `;
                }).join('');

            const summaryRows = Array.from(document.querySelectorAll('#summaryTable tbody tr'))
                .map((row, index) => {
                    const label = row.cells[0].textContent.trim();
                    const value = row.cells[1].textContent.trim();
                    const totalClass = index === 1 ? 'total-row' : ''; // Baris total
                    return `
                        <tr class="${totalClass} no-border-print">
                            <td style="font-weight: bold; width: 60%;">${label}</td>
                            <td class="text-right-print" style="font-weight: bold;">${value}</td>
                        </tr>
                    `;
                }).join('');

            // 2. Generate Konten Cetak (Disusun mirip Laporan, tanpa DataTables)
            const printHtml = `
                <div style="font-family:Arial,sans-serif; color: #000; max-width: 800px; margin: 0 auto;">
                    <h1 style="color:#1D4ED8; border-bottom: 2px solid #1D4ED8; padding-bottom: 10px; font-size: 20pt; text-align: center; margin-bottom: 20px;">
                        INVOICE RESMI
                    </h1>

                    <div style="display: flex; justify-content: space-between; margin-bottom: 20px; border-bottom: 1px solid #ddd; padding-bottom: 10px;">
                        <div>
                            <p style="font-size: 11pt; margin-bottom: 5px;"><strong>Nomor Invoice:</strong> ${invoiceNumber}</p>
                            <p style="font-size: 11pt; margin-bottom: 5px;"><strong>Tanggal Terbit:</strong> ${issueDate}</p>
                            <p style="font-size: 11pt;"><strong>Jatuh Tempo:</strong> ${dueDate}</p>
                        </div>
                        <div style="text-align: right;">
                            <span style="font-weight: bold; font-size: 14pt; padding: 5px 15px; border: 2px solid #1D4ED8; color: #1D4ED8;">
                                ${statusText}
                            </span>
                        </div>
                    </div>

                    <div style="display: flex; justify-content: space-between; gap: 20px; margin-bottom: 30px;">
                        <div style="width: 50%; padding: 10px; border: 1px solid #ddd;">
                            <h3 style="font-size: 12pt; margin-top: 0;"><strong>Dari:</strong></h3>
                            <p style="font-size: 10pt; margin: 0;">BNC Cloud Manager</p>
                            <p style="font-size: 10pt; margin: 0;">Jl. Palm Raya, Ruko No. 6</p>
                            <p style="font-size: 10pt; margin: 0;">Guntung Manggis, Banjarbaru</p>
                        </div>
                        <div style="width: 50%; padding: 10px; border: 1px solid #ddd;">
                            <h3 style="font-size: 12pt; margin-top: 0;"><strong>Untuk:</strong></h3>
                            <p style="font-size: 10pt; margin: 0;">${document.querySelector('#recipientInfo p:nth-child(2)').textContent.trim()}</p>
                            <p style="font-size: 10pt; margin: 0;">${document.querySelector('#recipientInfo p:nth-child(3)').textContent.trim()}</p>
                            <p style="font-size: 10pt; margin: 0;">Telp: ${document.querySelector('#recipientInfo p:nth-child(5)').textContent.replace('Telp: ', '').trim()}</p>
                        </div>
                    </div>

                    <h2 style="font-size: 14pt; margin-bottom: 10px; border-bottom: 1px solid #000; padding-bottom: 5px;">
                        Rincian Tagihan
                    </h2>

                    <table style="width:100%; border-collapse:collapse;">
                        <thead>
                            <tr>
                                <th style="background-color:#1D4ED8;color:white; width: 70%;">Deskripsi</th>
                                <th style="background-color:#1D4ED8;color:white; text-align:right;">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            ${itemRows}
                        </tbody>
                    </table>

                    <div style="width: 100%; display: flex; justify-content: flex-end; margin-top: 20px;">
                        <table class="no-border-print" style="width: 40%; float: right;">
                            <tbody>
                                ${summaryRows}
                            </tbody>
                        </table>
                    </div>

                    <div style="clear: both;"></div>

                    <p style="margin-top: 40px; text-align: right; font-size: 10pt;">
                        Hormat Kami,
                        <br><br><br><br>
                        (BNC Cloud Manager)
                    </p>
                </div>
            `;

            // 3. Masukkan konten ke kontainer cetak
            const printArea = document.getElementById('printArea');
            printArea.innerHTML = printHtml;

            // 4. Panggil cetak
            window.print();
        }
    </script>
</body>

</html>
