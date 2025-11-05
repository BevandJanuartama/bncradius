<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Transaksi - BNC Cloud Manager</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.5/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="{{ asset('css/datatable.css') }}">
    <link rel="stylesheet" href="{{ asset('css/popup.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <style>
        table.dataTable tbody tr:hover {
            background-color: #f3f4f6 !important;
            cursor: pointer;
        }

        /* PRINT CSS */
        @media print {
            body>*:not(.print-area) {
                display: none !important;
            }

            .print-area {
                display: block !important;
                position: absolute;
                top: 0;
                left: 0;
                width: 100%;
                padding: 20px;
                box-sizing: border-box;
                color: #000;
            }

            .print-area table {
                border-collapse: collapse;
                width: 100%;
            }

            .print-area th,
            .print-area td {
                border: 1px solid #000;
                padding: 8px;
                font-size: 10pt;
                text-align: left;
            }

            .print-area th {
                background-color: #eee;
            }

        }
    </style>
</head>

<body class="bg-gray-100 flex min-h-screen">

    {{-- BAR INCLUDE (Laravel Blade) --}}
    @switch(Auth::user()->level ?? '')
        @case('administrator')
            @include('layouts.subadminbar')
        @break

        @case('keuangan')
            @include('layouts.keuanganbar')
        @break

        @case('operator')
            @include('layouts.operatorbar')
        @break

        @case('teknisi')
            @include('layouts.teknisibar')
        @break
    @endswitch

    <main class="md:pl-72 pt-20 w-full p-6">
        <h2 class="text-4xl font-extrabold tracking-tight text-blue-500 flex items-center mb-8">
            <i class="fas fa-wallet w-8 h-8 mr-5 text-blue-500"></i>Transaksi
        </h2>
        {{-- CARD STATISTIK --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            @php
                $cards = [
                    ['id' => 'Pemasukan', 'color' => 'green'],
                    ['id' => 'Pengeluaran', 'color' => 'red'],
                    ['id' => 'Pendapatan', 'color' => 'blue'],
                ];
            @endphp

            @foreach ($cards as $card)
                <div id="card{{ $card['id'] }}"
                    class="bg-white rounded-xl shadow-md p-6 border-l-4 border-{{ $card['color'] }}-500
                   transform hover:-translate-y-1 hover:shadow-lg transition duration-300">
                    <div class="flex items-center justify-between mb-3">
                        <h3 class="text-lg font-semibold text-gray-700">{{ $card['id'] }}</h3>
                        <i
                            class="fas
                    {{ $card['id'] == 'Pemasukan' ? 'fa-arrow-down-long' : ($card['id'] == 'Pengeluaran' ? 'fa-arrow-up-long' : 'fa-money-check-dollar') }}
                    text-{{ $card['color'] }}-500 text-2xl"></i>
                    </div>
                    <p class="text-2xl font-bold text-{{ $card['color'] }}-500 value">Rp 0</p>
                    <div class="w-full bg-gray-200 rounded-full h-2 mt-3">
                        <div class="bg-{{ $card['color'] }}-500 h-2 rounded-full bar transition-all duration-500"
                            style="width: 0%"></div>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- KONTEN UTAMA --}}
        <div class="bg-white rounded-xl shadow-md border border-blue-200 border-t-4 border-t-blue-400 p-6">

            {{-- ALERT PENTING --}}
            <div
                class="group mb-8 relative rounded-xl bg-white p-6 shadow-xl shadow-blue-100 border border-blue-100 overflow-hidden transition-all duration-500">
                <div class="flex flex-col gap-3 relative z-10">
                    <div class="flex items-center gap-3 border-b border-blue-100 pb-3">
                        <div class="text-blue-600"><i class="fa-solid fa-lightbulb text-2xl"></i></div>
                        <h3 class="text-lg font-semibold text-blue-800">Perhatian Penting Mengenai Transaksi</h3>
                    </div>
                    <div class="text-gray-700 text-sm leading-relaxed space-y-1 pt-1">
                        <p><span class="font-bold text-blue-800">• Nilai total</span> pada data transaksi adalah total
                            pemasukan setelah dikurangi diskon, biaya admin, kode bayar, dan komisi mitra.</p>
                        <p><span class="font-bold text-blue-800">• Total nilai transaksi pemasukan</span> dari invoice
                            langganan yang sudah dihapus tetap dihitung / tidak dikurangi meskipun sudah terhapus.</p>
                        <p><span class="font-bold text-blue-800">• Transaksi pemasukan voucher</span> dihitung setelah
                            durasi pemakaian 5 menit.</p>
                    </div>
                </div>
            </div>

            {{-- BUTTONS LAPORAN & TAMBAH --}}
            <div class="mb-6 flex gap-3 flex-wrap">
                <button onclick="openModal('tambahModal')"
                    class="flex items-center gap-2 bg-emerald-500 text-white px-4 py-2 rounded-md font-medium shadow-md hover:bg-emerald-600 transition duration-500">
                    <i class="fas fa-circle-plus"></i> Tambah
                </button>
                <button onclick="openModal('harianModal')"
                    class="flex items-center gap-2 bg-blue-500 text-white px-4 py-2 rounded-md font-medium shadow-md hover:bg-blue-600 transition duration-500">
                    <i class="fas fa-file-lines"></i> Lap. Harian
                </button>
                <button onclick="openModal('bulananModal')"
                    class="flex items-center gap-2 bg-purple-500 text-white px-4 py-2 rounded-md font-medium shadow-md hover:bg-purple-600 transition duration-500">
                    <i class="fas fa-calendar-days"></i> Lap. Bulanan
                </button>
            </div>

            <div id="loading" class="flex justify-center items-center py-10">
                <div class="w-10 h-10 border-4 border-blue-400 border-t-transparent rounded-full animate-spin">
                </div>
            </div>

            {{-- DATATABLES TRANSAKSI --}}
            <div id="tableContainer" class="hidden bg-white shadow-lg rounded-2xl p-6 overflow-x-auto">
                <table id="transaksiTable" class="display w-full">
                    <thead>
                        <tr>
                            <th>Tanggal</th>
                            <th>Kategori</th>
                            <th>Jenis</th>
                            <th>Admin</th>
                            <th>Deskripsi</th>
                            <th>QTY</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($transaksi as $data)
                            <tr data-id="{{ $data->id }}">
                                <td>{{ \Carbon\Carbon::parse($data->tanggal)->format('Y-m-d') }}</td>
                                <td>{{ ucwords($data->kategori) }}</td>
                                <td>{{ $data->jenis ?? 'n/a' }}</td>
                                <td>{{ $data->admin_name ?? 'Sistem' }}</td>
                                <td>{{ $data->deskripsi }}</td>
                                <td>{{ $data->qty }}</td>
                                <td>{{ 'Rp ' . number_format($data->total_bersih, 0, ',', '.') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </main>

    {{-- MODAL DETAIL --}}
    <div id="detailModal" class="popup-modal hidden">
        <div class="popup-content">
            <h2 class="text-2xl font-bold text-blue-600 flex items-center gap-2 mb-4">
                <div class="p-2 bg-blue-500 rounded-lg text-white mr-3">
                    <i class="fas fa-file-alt text-xl"></i>
                </div>
                Detail Transaksi
            </h2>
            <form id="formDetail" class="space-y-4 text-gray-700">
                <input type="hidden" name="transaksi_id" id="detailTransaksiId">
                <div class="grid grid-cols-2 gap-4">
                    <div><label class="font-semibold">Tanggal:</label><input type="text" id="detailTanggal"
                            name="tanggal" class="w-full border p-2 rounded" readonly></div>
                    <div><label class="font-semibold">Kategori:</label><select id="detailKategori" name="kategori"
                            class="w-full border p-2 rounded" disabled>
                            <option value="Pemasukan">Pemasukan</option>
                            <option value="Pengeluaran">Pengeluaran</option>
                        </select></div>
                    <div><label class="font-semibold">Jenis:</label><input type="text" id="detailJenis"
                            name="jenis" class="w-full border p-2 rounded" readonly></div>
                    <div><label class="font-semibold">Admin:</label><input type="text" id="detailAdmin"
                            name="admin" class="w-full border p-2 rounded" readonly></div>
                    <div class="col-span-2"><label class="font-semibold">Deskripsi:</label><input type="text"
                            id="detailDeskripsi" name="deskripsi" class="w-full border p-2 rounded" readonly></div>
                    <div><label class="font-semibold">QTY:</label><input type="number" id="detailQty" name="qty"
                            class="w-full border p-2 rounded" readonly></div>
                    <div><label class="font-semibold">Total:</label><input type="text" id="detailTotal"
                            name="total" class="w-full border p-2 rounded" readonly></div>
                </div>
                <div class="flex justify-between mt-6">
                    <div class="flex gap-2">
                        <button type="button" id="btnEdit"
                            class="bg-yellow-500 text-white px-4 py-2 rounded-lg hover:bg-yellow-600"><i
                                class="fas fa-edit"></i> Edit</button>
                        <button type="button" id="btnHapus"
                            class="bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600"><i
                                class="fas fa-trash"></i> Hapus</button>
                    </div>
                    <div class="flex gap-2">
                        <button type="button" id="btnSimpan"
                            class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 hidden"><i
                                class="fas fa-save"></i> Simpan</button>
                        <button type="button" onclick="closeModal('detailModal')"
                            class="bg-gray-300 px-4 py-2 rounded-lg hover:bg-gray-400">Tutup</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- MODAL TAMBAH --}}
    <div id="tambahModal" class="popup-modal hidden">
        <div class="popup-content">
            <h2 class="text-2xl font-bold text-green-600 flex items-center gap-2 mb-4">
                <div class="w-10 h-10 bg-green-500 rounded-lg text-white flex items-center justify-center mr-2">
                    <i class="fas fa-plus-circle text-xl"></i>
                </div> Tambah Transaksi
            </h2>
            <form id="formTambah" action="{{ route('transaksi.store') }}" method="POST"
                class="space-y-4 text-gray-700">
                @csrf
                <div class="grid grid-cols-2 gap-4">
                    <div><label for="tanggalTambah" class="font-semibold">Tanggal:</label><input type="text"
                            id="tanggalTambah" name="tanggal" class="w-full border p-2 rounded flatpickr-input"
                            required></div>
                    <div><label for="kategoriTambah" class="font-semibold">Kategori:</label><select
                            id="kategoriTambah" name="kategori" class="w-full border p-2 rounded" required>
                            <option value="pemasukan">Pemasukan</option>
                            <option value="pengeluaran">Pengeluaran</option>
                        </select></div>
                    <div><label for="jenisTambah" class="font-semibold">Jenis:</label><input type="text"
                            id="jenisTambah" name="jenis" class="w-full border p-2 rounded"></div>
                    <div><label for="qtyTambah" class="font-semibold">QTY:</label><input type="number"
                            id="qtyTambah" name="qty" class="w-full border p-2 rounded" required value="1">
                    </div>
                    <div class="col-span-2"><label for="deskripsiTambah"
                            class="font-semibold">Deskripsi:</label><input type="text" id="deskripsiTambah"
                            name="deskripsi" class="w-full border p-2 rounded" required></div>
                    <div class="col-span-2"><label for="totalTambah" class="font-semibold">Total (Rp):</label><input
                            type="text" id="totalTambah" name="total" class="w-full border p-2 rounded"
                            required placeholder="Contoh: 100000"></div>
                </div>
                <div class="flex justify-end pt-4 gap-2">
                    <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700"><i
                            class="fas fa-save"></i> Tambah Transaksi</button>
                    <button type="button" onclick="closeModal('tambahModal')"
                        class="bg-gray-300 px-4 py-2 rounded-lg hover:bg-gray-400">Batal</button>
                </div>
            </form>
        </div>
    </div>

    {{-- MODAL HARIAN --}}
    <div id="harianModal" class="popup-modal hidden">
        <div class="popup-content">
            <h2 class="text-2xl font-bold text-blue-600 flex items-center gap-2 mb-4">
                <div class="w-10 h-10 bg-blue-500 rounded-lg text-white mr-2 flex items-center justify-center">
                    <i class="fas fa-file-lines text-xl"></i>
                </div> Laporan Harian
            </h2>
            <div class="space-y-4 text-gray-700">
                <div><label for="harianAwal" class="font-semibold">Tanggal:</label><input type="text"
                        id="harianAwal" class="w-full border p-2 rounded flatpickr-input"></div>
                <div><label for="harianJenis" class="font-semibold">Jenis Laporan:</label><select id="harianJenis"
                        class="w-full border p-2 rounded">
                        <option value="Semua">Semua</option>
                        <option value="Pemasukan">Pemasukan</option>
                        <option value="Pengeluaran">Pengeluaran</option>
                    </select></div>
                <div class="flex justify-end pt-4 gap-2">
                    <button onclick="printLaporan('harian')"
                        class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700"><i
                            class="fas fa-print"></i> Cetak Laporan</button>
                    <button type="button" onclick="closeModal('harianModal')"
                        class="bg-gray-300 px-4 py-2 rounded-lg hover:bg-gray-400">Tutup</button>
                </div>
            </div>
        </div>
    </div>

    {{-- MODAL BULANAN --}}
    <div id="bulananModal" class="popup-modal hidden">
        <div class="popup-content">
            <h2 class="text-2xl font-bold text-indigo-600 flex items-center gap-2 mb-4">
                <div class="w-10 h-10 bg-indigo-500 rounded-lg text-white mr-2 flex items-center justify-center">
                    <i class="fas fa-calendar-days text-xl"></i>
                </div> Laporan Bulanan
            </h2>
            <div class="space-y-4 text-gray-700">
                <div><label for="bulananAwal" class="font-semibold">Tanggal Awal:</label><input type="text"
                        id="bulananAwal" class="w-full border p-2 rounded flatpickr-input"></div>
                <div><label for="bulananAkhir" class="font-semibold">Tanggal Akhir:</label><input type="text"
                        id="bulananAkhir" class="w-full border p-2 rounded flatpickr-input"></div>
                <div><label for="bulananJenis" class="font-semibold">Jenis Laporan:</label><select id="bulananJenis"
                        class="w-full border p-2 rounded">
                        <option value="Semua">Semua</option>
                        <option value="Pemasukan">Pemasukan</option>
                        <option value="Pengeluaran">Pengeluaran</option>
                    </select></div>
                <div class="flex justify-end pt-4 gap-2">
                    <button onclick="printLaporan('bulanan')"
                        class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700"><i
                            class="fas fa-print"></i> Cetak Laporan</button>
                    <button type="button" onclick="closeModal('bulananModal')"
                        class="bg-gray-300 px-4 py-2 rounded-lg hover:bg-gray-400">Tutup</button>
                </div>
            </div>
        </div>
    </div>

    {{-- KONTEN CETAK TERSEMBUNYI --}}
    <div id="printArea" class="print-area hidden"></div>

    {{-- SCRIPTS --}}
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

    <script>
        < script src = "https://code.jquery.com/jquery-3.6.0.min.js" >
    </script>
    <script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

    <script>
        // Pastikan Anda mendefinisikan route Laravel yang sesuai di file web.php
        // Contoh:
        // Route::post('/transaksi', [TransaksiController::class, 'store'])->name('transaksi.store');
        // Route::put('/transaksi/{id}', [TransaksiController::class, 'update'])->name('transaksi.update');
        // Route::delete('/transaksi/{id}', [TransaksiController::class, 'destroy'])->name('transaksi.destroy');
        const ENDPOINT_STORE = '{{ route('transaksi.store') }}';
        // Asumsi route update dan delete memiliki placeholder {id}. Anda harus menyesuaikannya.
        const ENDPOINT_UPDATE = '/transaksi/'; // Akan ditambahkan ID
        const ENDPOINT_DELETE = '/transaksi/'; // Akan ditambahkan ID

        const CURRENT_ADMIN_NAME = "{{ Auth::user()->name ?? 'Admin BNC' }}";
        let transaksiTable;
        let selectedRowNode = null;

        // Cache Elemen
        const $cardPemasukan = $("#cardPemasukan"),
            $cardPengeluaran = $("#cardPengeluaran"),
            $cardPendapatan = $("#cardPendapatan");
        const $detailFormInputs = $('#formDetail input, #formDetail select');
        const $btnSimpan = $('#btnSimpan');

        // Helper Modal
        const openModal = (id) => $(`#${id}`).removeClass('hidden').addClass('flex');
        const closeModal = (id) => $(`#${id}`).addClass('hidden').removeClass('flex');

        // Helper Rupiah
        const parseRupiah = (v) => parseInt((v || "").toString().replace(/Rp|\s|\./g, "").replace(/,/g, "")) || 0;
        const formatRupiah = (n) => 'Rp ' + n.toLocaleString('id-ID');

        // Helper untuk membuat token CSRF
        const csrfToken = $('meta[name="csrf-token"]').attr('content') || '{{ csrf_token() }}';

        // ... (Fungsi updateCards dan printLaporan tetap sama seperti sebelumnya) ...
        /** Update Statistik Card */
        function updateCards() {
            let totalPemasukan = 0,
                totalPengeluaran = 0;

            transaksiTable.rows({
                search: 'applied'
            }).data().each(function(rowData) {
                const kategori = rowData[1].trim().toLowerCase();
                const total = parseRupiah(rowData[6]);
                kategori === "pemasukan" ? totalPemasukan += total : totalPengeluaran += total;
            });

            const pendapatan = totalPemasukan - totalPengeluaran;
            const totalAll = totalPemasukan + totalPengeluaran;
            const persenPemasukan = totalAll > 0 ? Math.round((totalPemasukan / totalAll) * 100) : 0;
            const persenPengeluaran = totalAll > 0 ? Math.round((totalPengeluaran / totalAll) * 100) : 0;
            const persenPendapatan = totalPemasukan > 0 ? Math.round((pendapatan / totalPemasukan) * 100) : 0;

            const barPendapatanWidth = pendapatan >= 0 ? persenPendapatan : 0;
            const barPendapatanColor = pendapatan >= 0 ? "bg-blue-500" : "bg-red-500";

            $cardPemasukan.find(".bar").css("width", persenPemasukan + "%");
            $cardPemasukan.find(".value").text(formatRupiah(totalPemasukan));

            $cardPengeluaran.find(".bar").css("width", persenPengeluaran + "%");
            $cardPengeluaran.find(".value").text(formatRupiah(totalPengeluaran));

            $cardPendapatan.find(".bar").css("width", Math.abs(barPendapatanWidth) + "%").removeClass(
                "bg-blue-500 bg-red-500").addClass(barPendapatanColor);
            $cardPendapatan.find(".value").text(formatRupiah(pendapatan));
        }

        /** Cetak Laporan (Harian/Bulanan) */
        function printLaporan(type) {
            if (!transaksiTable) return;

            let awal, akhir, jenisFilter, title, color;
            if (type === "harian") {
                awal = $('#harianAwal').val();
                akhir = awal;
                jenisFilter = $('#harianJenis').val();
                title = "Laporan Harian";
                color = "#2563EB";
                if (!awal) {
                    alert(`Harap pilih tanggal untuk Laporan Harian.`);
                    return;
                }
            } else {
                awal = $('#bulananAwal').val();
                akhir = $('#bulananAkhir').val();
                jenisFilter = $('#bulananJenis').val();
                title = "Laporan Bulanan";
                color = "#4F46E5";
                if (!awal || !akhir) {
                    alert(`Harap pilih tanggal Awal dan Akhir untuk Laporan Bulanan.`);
                    return;
                }
            }

            let totalPemasukan = 0,
                totalPengeluaran = 0,
                tableRows = '',
                totalBaris = 0;

            transaksiTable.rows({
                search: 'applied'
            }).data().toArray().forEach((rowData) => {
                const [rowTanggal, rowKategori, , , , , rowTotalRp] = rowData;
                const rowKategoriLower = rowKategori.trim().toLowerCase();
                const rowTotal = parseRupiah(rowTotalRp);

                const isDateInRange = (type === "harian" && rowTanggal === awal) || (type === "bulanan" &&
                    rowTanggal >= awal && rowTanggal <= akhir);
                const isKategoriIncluded = jenisFilter === 'Semua' || rowKategoriLower === jenisFilter
                    .toLowerCase();

                if (isDateInRange && isKategoriIncluded) {
                    tableRows +=
                        `<tr><td style="font-size: 10pt;">${rowTanggal}</td><td style="font-size: 10pt;">${rowKategori}</td><td style="font-size: 10pt;">${rowData[4]}</td><td style="font-size: 10pt; text-align:right;">${rowTotalRp}</td></tr>`;
                    totalBaris++;
                    rowKategoriLower === 'pemasukan' ? totalPemasukan += rowTotal : totalPengeluaran += rowTotal;
                }
            });

            if (totalBaris === 0) {
                alert("Tidak ada data transaksi yang ditemukan untuk kriteria filter yang dipilih!");
                return;
            }

            const totalPendapatan = totalPemasukan - totalPengeluaran;

            // Generate HTML Cetak
            const printHtml = `
            <div style="font-family:Arial,sans-serif; color: #000;">
                <h2 style="color:${color}; border-bottom: 2px solid ${color}; padding-bottom: 5px; font-size: 18pt;">${title}</h2>
                <p style="margin-bottom: 5px; font-size: 11pt;"><strong>Periode:</strong> ${awal} ${type === 'bulanan' ? `s/d ${akhir}` : ''}</p>
                <p style="margin-bottom: 15px; font-size: 11pt;"><strong>Jenis Transaksi:</strong> ${jenisFilter}</p>
                <div style="margin-bottom: 15px; padding: 10px; border: 1px solid #ddd; font-size: 12pt;">
                    <p>Total Pemasukan: <strong>${formatRupiah(totalPemasukan)}</strong></p>
                    <p>Total Pengeluaran: <strong>${formatRupiah(totalPengeluaran)}</strong></p>
                    <p>Total Pendapatan: <strong>${formatRupiah(totalPendapatan)}</strong></p>
                </div>
                <table style="width:100%; border-collapse:collapse;">
                    <thead><tr>
                        <th style="background-color:${color};color:white;">Tanggal</th>
                        <th style="background-color:${color};color:white;">Kategori</th>
                        <th style="background-color:${color};color:white;">Deskripsi</th>
                        <th style="background-color:${color};color:white; text-align:right;">Total</th>
                    </tr></thead><tbody>${tableRows}</tbody>
                </table>
                <p style="margin-top: 20px; font-style: italic; font-size: 9pt;">*Catatan: Data yang dicetak adalah hasil filter tanggal dan jenis yang dipilih.</p>
            </div>`;

            $('#printArea').html(printHtml);
            closeModal(type + "Modal");
            window.print();
        }
        // ...

        $(document).ready(function() {
            // ... (Inisialisasi DataTables dan Flatpickr tetap sama) ...
            transaksiTable = $('#transaksiTable').DataTable({
                responsive: true,
                drawCallback: updateCards,
                ordering: false,
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/id.json'
                },
                initComplete: function() {
                    $('#loading').hide();
                    $('#tableContainer').removeClass('hidden').hide().fadeIn(200);
                }
            });

            const flatpickrConfig = {
                dateFormat: "Y-m-d",
                allowInput: true
            };
            const harianPicker = flatpickr("#harianAwal", flatpickrConfig);
            const bulananAwalPicker = flatpickr("#bulananAwal", flatpickrConfig);
            const bulananAkhirPicker = flatpickr("#bulananAkhir", flatpickrConfig);
            const detailPicker = flatpickr("#detailTanggal", flatpickrConfig);
            flatpickr("#tanggalTambah", flatpickrConfig);

            harianPicker.setDate(new Date(), true);
            bulananAwalPicker.setDate(new Date(), true);
            bulananAkhirPicker.setDate(new Date(), true);

            // KLIK ROW → DETAIL MODAL (Tetap sama)
            $('#transaksiTable tbody').on('click', 'tr', function() {
                const rowData = transaksiTable.row(this).data();
                if (!rowData) return;

                selectedRowNode = this;
                const transaksiId = $(this).data('id');

                $('#detailTransaksiId').val(transaksiId);
                $('#detailTanggal').val(rowData[0]);
                detailPicker.setDate(rowData[0], true);
                $('#detailKategori').val(rowData[1]);
                $('#detailJenis').val(rowData[2]);
                $('#detailAdmin').val(rowData[3]);
                $('#detailDeskripsi').val(rowData[4]);
                $('#detailQty').val(rowData[5]);
                $('#detailTotal').val(rowData[6]);

                $detailFormInputs.prop('readonly', true).prop('disabled', true);
                $btnSimpan.addClass('hidden');
                openModal('detailModal');
            });

            // Tombol Edit (Tetap sama)
            $('#btnEdit').on('click', function() {
                $detailFormInputs.prop('readonly', false).prop('disabled', false);
                $('#detailAdmin').prop('readonly', true).prop('disabled', true);
                $btnSimpan.removeClass('hidden');
            });


            $('#formTambah').on('submit', function(e) {
                e.preventDefault();

                const form = this;
                const totalValue = parseRupiah(form.total.value);
                const totalFormatted = formatRupiah(totalValue);

                const dataToStore = {
                    _token: csrfToken,
                    tanggal: form.tanggal.value,
                    kategori: form.kategori.value,
                    jenis: form.jenis.value,
                    deskripsi: form.deskripsi.value,
                    qty: form.qty.value,
                    total: totalValue, // Kirim nilai numerik ke server
                    admin_name: CURRENT_ADMIN_NAME // Menggunakan nama admin saat ini
                };

                $.ajax({
                    url: ENDPOINT_STORE,
                    method: 'POST',
                    data: dataToStore,
                    success: function(response) {
                        // ASUMSI: Backend mengembalikan objek transaksi yang baru DITAMBAH (termasuk ID baru)
                        const newId = response.id || Math.floor(Math.random() *
                            100000); // Simulasi ID baru jika tidak ada

                        // Tambahkan baris baru ke DataTables
                        transaksiTable.row.add([
                            dataToStore.tanggal,
                            dataToStore.kategori,
                            dataToStore.jenis,
                            dataToStore.admin_name,
                            dataToStore.deskripsi,
                            dataToStore.qty,
                            totalFormatted
                        ]).node().dataset.id = newId; // Tambahkan data-id

                        transaksiTable.draw(false);
                        closeModal('tambahModal');
                        alert('✅ Transaksi berhasil ditambahkan!');
                        form.reset();
                    },
                    error: function(xhr) {
                        alert('❌ Gagal menambahkan transaksi. Cek console atau server logs.');
                        console.error('AJAX Error:', xhr.responseText);
                    }
                });
            });

            $('#btnSimpan').on('click', function() {
                if (!selectedRowNode) return;

                const form = document.forms['formDetail'];
                const transaksiId = $('#detailTransaksiId').val();

                const totalValue = parseRupiah(form.total.value);
                const totalFormatted = formatRupiah(totalValue);

                const dataToUpdate = {
                    _token: csrfToken,
                    _method: 'PUT', // Penting untuk Laravel
                    tanggal: form.tanggal.value,
                    kategori: form.kategori.value,
                    jenis: form.jenis.value,
                    deskripsi: form.deskripsi.value,
                    qty: form.qty.value,
                    total_bersih: totalValue, // Kirim nilai numerik
                };

                $.ajax({
                    url: ENDPOINT_UPDATE + transaksiId,
                    method: 'POST', // Kirim sebagai POST, Laravel akan menginterpretasikannya sebagai PUT karena _method
                    data: dataToUpdate,
                    success: function(response) {
                        // Update baris DataTables di sisi klien
                        transaksiTable.row(selectedRowNode).data([
                            dataToUpdate.tanggal,
                            dataToUpdate.kategori,
                            dataToUpdate.jenis,
                            form.admin
                            .value, // Admin tidak berubah di form, jadi gunakan nilai lama
                            dataToUpdate.deskripsi,
                            dataToUpdate.qty,
                            totalFormatted
                        ]).draw(false);

                        closeModal('detailModal');
                        alert('✅ Transaksi ID ' + transaksiId + ' berhasil diupdate!');
                    },
                    error: function(xhr) {
                        alert('❌ Gagal mengupdate transaksi. Cek console atau server logs.');
                        console.error('AJAX Error:', xhr.responseText);
                    }
                });
            });


            $('#btnHapus').on('click', function() {
                if (!selectedRowNode) return;

                const transaksiId = $('#detailTransaksiId').val();

                if (confirm("Yakin ingin menghapus transaksi ID " + transaksiId + " ini?")) {
                    $.ajax({
                        url: ENDPOINT_DELETE + transaksiId,
                        method: 'POST', // Kirim sebagai POST, Laravel akan menginterpretasikannya sebagai DELETE karena _method
                        data: {
                            _token: csrfToken,
                            _method: 'DELETE' // Penting untuk Laravel
                        },
                        success: function(response) {
                            // Hapus baris dari DataTables
                            transaksiTable.row(selectedRowNode).remove().draw(false);
                            closeModal('detailModal');
                            alert('✅ Transaksi ID ' + transaksiId + ' berhasil dihapus!');
                        },
                        error: function(xhr) {
                            alert('❌ Gagal menghapus transaksi. Cek console atau server logs.');
                            console.error('AJAX Error:', xhr.responseText);
                        }
                    });
                }
            });

            // ... (Logika filter DataTables tetap sama) ...
            const today = new Date();
            const currentMonth = ("0" + (today.getMonth() + 1)).slice(-2);
            const currentYear = today.getFullYear();
            const monthOptions = ["01", "02", "03", "04", "05", "06", "07", "08", "09", "10", "11", "12"].map((m,
                    i) =>
                `<option value="${m}">${new Date(0,i).toLocaleString("id-ID",{month:"long"})}</option>`).join(
                "");
            const yearOptions = [currentYear, currentYear - 1, currentYear + 1].map(y =>
                `<option value="${y}">${y}</option>`).join('');

            $("#transaksiTable_length").addClass("flex items-center justify-between w-full").append(`
            <div class="ml-4 flex items-center gap-2 flex-wrap">
                <label class="font-semibold">Bulan:</label>
                <select id="filterBulan" class="border p-1 rounded"><option value="">Semua</option>${monthOptions}</select>
                <label class="font-semibold">Tahun:</label>
                <select id="filterTahun" class="border p-1 rounded"><option value="">Semua</option>${yearOptions}</select>
            </div>
        `);

            $.fn.dataTable.ext.search.push(function(settings, data) {
                const [tanggal, , , , , , ] = data;
                const bulanFilter = $('#filterBulan').val();
                const tahunFilter = $('#filterTahun').val();

                if (!tanggal || (!bulanFilter && !tahunFilter)) return true;

                const [tahunTabel, bulanTabel] = tanggal.split('-');
                const isBulanMatch = !bulanFilter || bulanTabel === bulanFilter;
                const isTahunMatch = !tahunFilter || tahunTabel === tahunFilter;

                return isBulanMatch && isTahunMatch;
            });

            $('#filterBulan').val(currentMonth);
            $('#filterTahun').val(currentYear);
            transaksiTable.draw();

            $(document).on('change', '#filterBulan, #filterTahun', () => transaksiTable.draw());
        });
    </script>
    </script>
</body>

</html>
