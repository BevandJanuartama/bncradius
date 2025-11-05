<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>BNC CLOUD MANAGER - Remote</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="{{ asset('css/datatable.css') }}">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

</head>

<body class="bg-gray-50 flex min-h-screen">

    @include('layouts.sidebar')

    <main class="md:pl-72 pt-20 w-full p-6">

        <div class="flex items-center mb-8">
            <h2 class="text-4xl font-extrabold tracking-tight text-blue-500 flex items-center">
                <i class="fas fa-network-wired w-8 h-8 mr-5 text-blue-500"></i>
                VPN Remote
            </h2>
        </div>

        <div class="group mb-6 relative rounded-xl bg-white p-6 shadow-sm border border-blue-100">
            <div class="flex flex-col gap-3 relative z-10">
                <div class="flex items-center gap-3 border-b border-blue-100 pb-3">
                    <div class="text-blue-600">
                        <i class="fa-solid fa-circle-info text-2xl"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-blue-800">
                        Informasi Penting Mengenai VPN Remote
                    </h3>
                </div>

                <div class="text-gray-700 text-sm leading-relaxed space-y-1 pt-1">
                    <p>
                        <span class="font-bold text-blue-800">• VPN Remote</span> digunakan untuk melakukan akses jarak
                        jauh (remote)
                        ke perangkat <span class="font-semibold text-blue-700">Mikrotik</span> Anda dari luar jaringan
                        lokal.
                    </p>
                    <p>
                        <span class="font-bold text-blue-800">• Layanan ini</span> hanya tersedia untuk pengguna paket
                        <span class="font-semibold text-blue-700">RLCloud Premium</span> ke atas.
                    </p>
                    <p>
                        <span class="font-bold text-blue-800">• Panduan video</span> tersedia di YouTube untuk membantu
                        proses setup:
                        <a href="https://www.youtube.com/watch?v=E5xPXkf-cOE&list=PLVA91M9nFgiyTfSrQctnx2vBdnp7IRsYJ&index=2"
                            target="_blank" class="text-blue-600 underline font-semibold hover:text-blue-700">
                            Lihat Panduan Video
                        </a>
                    </p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-md border border-blue-200 border-t-4 border-t-blue-400 p-6 mb-8">
            <h2 class="text-xl font-bold text-blue-600 mb-4">VPN Account</h2>
            <div class="mb-6 flex gap-3">
                <button onclick="openVpnModal()"
                    class="flex items-center gap-2 bg-emerald-500 text-white px-4 py-2 rounded-md font-medium shadow-md hover:bg-emerald-600 transition duration-500">
                    <i class="fas fa-circle-plus"></i>Tambah
                </button>
            </div>

            <div id="vpnAccountLoading" class="flex justify-center items-center py-10">
                <div class="w-10 h-10 border-4 border-blue-400 border-t-transparent rounded-full animate-spin">
                </div>
            </div>

            <div id="vpnAccountTableContainer" class="hidden bg-white shadow-lg rounded-2xl p-6 overflow-x-auto">
                <table id="vpnAccountTable" class="display w-full text-sm">
                    <thead>
                        <tr>
                            <th>Instance</th>
                            <th>Perusahaan</th>
                            <th>Router</th>
                            <th>Username</th>
                            <th>Password</th>
                            <th>IP Address</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>123456789</td>
                            <td>PT Radius</td>
                            <td>Router1</td>
                            <td>borneo1</td>
                            <td>123456</td>
                            <td>172.20.183.1</td>
                            <td class="flex justify-center items-center gap-2 align-middle">
                                <button onclick="openEditModal(this)" aria-label="Edit VPN Account"
                                    class="flex items-center justify-center gap-1 bg-gradient-to-r from-blue-500 to-blue-600 text-white text-sm px-3 py-1 rounded-md font-medium shadow-sm hover:from-blue-600 hover:to-blue-700 transition-all duration-200">
                                    <i class="fas fa-pen text-xs"></i>
                                    Edit
                                </button>

                                <button onclick="deleteVpnAccount(this)" aria-label="Hapus VPN Account"
                                    class="flex items-center justify-center gap-1 bg-gradient-to-r from-red-500 to-red-600 text-white text-sm px-3 py-1 rounded-md font-medium shadow-sm hover:from-red-600 hover:to-red-700 transition-all duration-200">
                                    <i class="fas fa-trash text-xs"></i>
                                    Hapus
                                </button>
                            </td>

                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-md border border-blue-200 border-t-4 border-t-blue-400 p-6">
            <h2 class="text-xl font-bold text-blue-500 mb-4">VPN Firewall</h2>
            <div class="mb-6 flex gap-3">
                <button onclick="openFirewallModal()"
                    class="flex items-center gap-2 bg-emerald-500 text-white px-4 py-2 rounded-md font-medium shadow-md hover:bg-emerald-600 transition duration-500">
                    <i class="fas fa-circle-plus"></i>Tambah
                </button>
            </div>

            <div id="vpnFirewallLoading" class="flex justify-center items-center py-10">
                <div class="w-10 h-10 border-4 border-blue-400 border-t-transparent rounded-full animate-spin">
                </div>
            </div>

            <div id="vpnFirewallTableContainer" class="hidden bg-white shadow-lg rounded-2xl p-6 overflow-x-auto">
                <table id="vpnFirewallTable" class="display w-full text-sm">
                    <thead>
                        <tr>
                            <th>Instance</th>
                            <th>Router</th>
                            <th>Remote Address</th>
                            <th>Protocol</th>
                            <th>Port tujuan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>123456789</td>
                            <td>Router1</td>
                            <td>172.20.183.1</td>
                            <td>TCP</td>
                            <td>8291</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </main>

    <div id="vpnModal" class="hidden fixed inset-0 items-center justify-center bg-black bg-opacity-50 z-50">
        <div class="bg-white p-6 rounded-lg shadow-lg sm:w-[600px] max-w-full">
            <h2 class="text-lg font-bold mb-4">Tambah VPN Account</h2>
            <form onsubmit="event.preventDefault(); saveVpnAccount();">
                @csrf
                <div class="mb-3">
                    <label class="block text-sm font-medium">Instance</label>
                    <select name="instance_id" class="w-full border border-gray-400 rounded px-3 py-2">
                        <option>Instance</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="block text-sm font-medium">Nama Router</label>
                    <input type="text" id="routerName" name="router"
                        class="w-full border border-gray-400 rounded px-3 py-2" required>
                </div>

                <div class="mb-3">
                    <label class="block text-sm font-medium">Password VPN</label>
                    <input type="text" id="vpnPassword" name="password"
                        class="w-full border border-gray-400 rounded px-3 py-2" required>
                </div>

                <input type="hidden" id="vpnUsername" name="username">

                <div class="flex justify-end gap-2">
                    <button type="button" onclick="closeVpnModal()"
                        class="px-4 py-2 bg-gray-400 text-white rounded">Batal</button>
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    <div id="editVpnModal" class="hidden fixed inset-0 items-center justify-center bg-black bg-opacity-50 z-50">
        <div class="bg-white p-6 rounded-lg shadow-lg sm:w-[600px] max-w-full">
            <h2 class="text-lg font-bold mb-4">Edit VPN Account</h2>
            <form onsubmit="event.preventDefault(); closeEditModal();">
                <div class="mb-3">
                    <label class="block text-sm font-medium">Nama Router</label>
                    <input type="text" id="editRouter" class="w-full border border-gray-400 rounded px-3 py-2">
                </div>

                <div class="mb-3">
                    <label class="block text-sm font-medium">Password VPN</label>
                    <input type="text" id="editPassword" class="w-full border border-gray-400 rounded px-3 py-2">
                </div>

                <hr class="my-4 border-t-2 border-gray-300">

                <h3 class="text-md font-semibold mb-2">Script VPN</h3>

                <div class="mb-3">
                    <label class="block text-sm font-medium">Jenis VPN</label>
                    <select id="vpnType" class="w-full border border-gray-400 rounded px-3 py-2"
                        onchange="updateVpnScript()">
                        <option value="">-- Pilih Jenis VPN --</option>
                        <option value="ovpn">OVPN</option>
                        <option value="sstp">SSTP</option>
                        <option value="l2tp">L2TP</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="block text-sm font-medium">Script VPN</label>
                    <textarea id="vpnScript" rows="5" class="w-full border border-gray-400 rounded px-3 py-2"
                        placeholder="Script VPN akan muncul otomatis..." readonly></textarea>
                </div>

                <div class="flex justify-end gap-2">
                    <button type="button" onclick="closeEditModal()"
                        class="px-4 py-2 bg-gray-400 text-white rounded">Batal</button>
                    <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded">Simpan perubahan</button>
                </div>
            </form>
        </div>
    </div>

    <div id="firewallModal" class="hidden fixed inset-0 items-center justify-center bg-black bg-opacity-50 z-50">
        <div class="bg-white p-6 rounded-lg shadow-lg sm:w-[600px] max-w-full">
            <h2 class="text-lg font-bold mb-4">Tambah VPN Firewall</h2>
            <form onsubmit="event.preventDefault(); closeFirewallModal();">
                @csrf
                <div class="mb-3">
                    <label class="block text-sm font-medium">Router</label>
                    <select name="router_id" class="w-full border border-gray-400 rounded px-3 py-2">
                        <option>Router 1</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="block text-sm font-medium">Protocol</label>
                    <select name="protocol" class="w-full border border-gray-400 rounded px-3 py-2">
                        <option value="tcp">TCP</option>
                        <option value="udp">UDP</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="block text-sm font-medium">Port Tujuan</label>
                    <input type="number" name="port" class="w-full border border-gray-400 rounded px-3 py-2"
                        placeholder="Contoh: 8291" required>
                </div>

                <div class="flex justify-end gap-2">
                    <button type="button" onclick="closeFirewallModal()"
                        class="px-4 py-2 bg-gray-400 text-white rounded">Batal</button>
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            // Inisialisasi DataTables VPN Account
            $('#vpnAccountTable').DataTable({
                responsive: true,
                ordering: false,
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/id.json'
                },
                initComplete: function() {
                    // Menggunakan ID unik
                    $('#vpnAccountLoading').hide();
                    $('#vpnAccountTableContainer').removeClass('hidden').hide().fadeIn(200);
                }
            });

            // Inisialisasi DataTables VPN Firewall
            $('#vpnFirewallTable').DataTable({
                responsive: true,
                ordering: false,
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/id.json'
                },
                initComplete: function() {
                    // Menggunakan ID unik
                    $('#vpnFirewallLoading').hide();
                    $('#vpnFirewallTableContainer').removeClass('hidden').hide().fadeIn(200);
                }
            });
        });

        let vpnCounter = 2; // Mulai dari 2 karena borneo1 sudah ada di baris contoh

        function saveVpnAccount() {
            let router = document.getElementById("routerName").value;
            let password = document.getElementById("vpnPassword").value;

            // Logika sederhana untuk menghasilkan username unik
            let newUsername = "borneo" + vpnCounter++;
            document.getElementById("vpnUsername").value = newUsername;

            let table = $("#vpnAccountTable").DataTable();

            // Menyatukan gaya tombol agar konsisten dengan baris contoh
            let actionButtons = `
                <div class="flex justify-center items-center gap-2">
                    <button onclick="openEditModal(this)" aria-label="Edit VPN Account"
                        class="flex items-center justify-center gap-1 bg-gradient-to-r from-blue-500 to-blue-600 text-white text-sm px-3 py-1 rounded-md font-medium shadow-sm hover:from-blue-600 hover:to-blue-700 transition-all duration-200">
                        <i class="fas fa-pen text-xs"></i>
                        Edit
                    </button>
                    <button onclick="deleteVpnAccount(this)" aria-label="Hapus VPN Account"
                        class="flex items-center justify-center gap-1 bg-gradient-to-r from-red-500 to-red-600 text-white text-sm px-3 py-1 rounded-md font-medium shadow-sm hover:from-red-600 hover:to-red-700 transition-all duration-200">
                        <i class="fas fa-trash text-xs"></i>
                        Hapus
                    </button>
                </div>
            `;

            table.row.add([
                "123456789",
                "PT Radius",
                router,
                newUsername,
                password,
                "172.20.183.1",
                actionButtons // Menggunakan tombol dengan gaya yang konsisten
            ]).draw(false);

            closeVpnModal();

            // Reset form
            document.getElementById("routerName").value = "";
            document.getElementById("vpnPassword").value = "";
            document.getElementById("vpnUsername").value = "";
        }

        function updateVpnScript() {
            let vpnType = document.getElementById("vpnType").value;
            let scriptField = document.getElementById("vpnScript");

            // Mengambil nilai dari field edit modal (asumsi sudah terisi saat openEditModal)
            let username = document.getElementById("editRouter").value;
            let password = document.getElementById("editPassword").value;
            let vpnServer = "YOUR_VPN_SERVER_IP"; // Ganti dengan IP Server VPN yang sebenarnya

            let scripts = {
                ovpn: `/interface ovpn-client add connect-to=${vpnServer} user=${username} password=${password} disabled=no profile=default-encryption`,
                sstp: `/interface sstp-client add connect-to=${vpnServer} user=${username} password=${password} disabled=no`,
                l2tp: `/interface l2tp-client add connect-to=${vpnServer} user=${username} password=${password} disabled=no use-ipsec=yes ipsec-secret=SECRET`
            };

            // Menambahkan readonly pada textarea Script VPN di HTML agar pengguna tidak bisa mengedit script Mikrotik
            scriptField.value = scripts[vpnType] ? scripts[vpnType].replace('USERNAME', username).replace('PASSWORD', password) : "";
        }

        function openVpnModal() {
            toggleModal("vpnModal", true);
        }

        function closeVpnModal() {
            toggleModal("vpnModal", false);
        }

        function openFirewallModal() {
            toggleModal("firewallModal", true);
        }

        function closeFirewallModal() {
            toggleModal("firewallModal", false);
        }

        function openEditModal(button) {
            let row = $(button).closest('tr');
            let data = $('#vpnAccountTable').DataTable().row(row).data();

            // Mengisi field edit modal dengan data dari baris
            // data[2] adalah Router, data[4] adalah Password
            document.getElementById("editRouter").value = data[2];
            document.getElementById("editPassword").value = data[4];

            document.getElementById("vpnType").value = "";
            document.getElementById("vpnScript").value = "";

            toggleModal("editVpnModal", true);
        }

        function closeEditModal() {
            toggleModal("editVpnModal", false);
        }

        function deleteVpnAccount(button) {
            // Konfirmasi sebelum menghapus (opsional, tapi disarankan)
            if (confirm("Anda yakin ingin menghapus akun VPN ini?")) {
                let table = $("#vpnAccountTable").DataTable();
                table.row($(button).closest('tr')).remove().draw();
            }
        }

        // helper untuk modal
        function toggleModal(id, show = true) {
            let modal = document.getElementById(id);
            if (show) {
                modal.classList.remove("hidden");
                modal.classList.add("flex");
            } else {
                modal.classList.add("hidden");
                modal.classList.remove("flex");
            }
        }

        // close modal on outside click
        ["vpnModal", "firewallModal", "editVpnModal"].forEach(id => {
            document.getElementById(id).addEventListener("click", function(e) {
                if (e.target === this) toggleModal(id, false);
            });
        });
    </script>

</body>

</html>
