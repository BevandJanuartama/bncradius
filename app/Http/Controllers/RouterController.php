<?php

namespace App\Http\Controllers;

use App\Models\Router;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class RouterController extends Controller
{
    // Menampilkan semua router yang tersimpan di database
    public function index()
    {
        // Ambil semua data router dari tabel routers
        $routers = Router::all();

        // Kirim data router ke view index
        return view('admin-sub.routers.index', compact('routers'));
    }

    // Menampilkan halaman form untuk menambahkan router baru
    public function create()
    {
        // Kembali ke view form create router
        return view('admin-sub.routers.create');
    }

    // Menyimpan data router baru ke database
    public function store(Request $request)
    {
        // Validasi input pengguna sebelum disimpan
        $request->validate([
            'nama_router' => 'required|string|max:255', // nama router wajib diisi
            'tipe_koneksi' => 'required|in:ip_public,vpn_radius', // hanya dua pilihan koneksi
            'ip_address' => 'nullable|ip' // jika diisi harus format IP valid
        ]);

        // Simpan data router baru ke database
        Router::create([
            'nama_router' => $request->nama_router, // nama router dari input
            'tipe_koneksi' => $request->tipe_koneksi, // tipe koneksi (ip_public/vpn_radius)
            // jika tipe koneksi ip_public → pakai input user
            // jika vpn_radius → generate IP random 172.31.x.x
            'ip_address' => $request->tipe_koneksi === 'ip_public'
                ? $request->ip_address
                : '172.31.' . rand(0, 255) . '.' . rand(1, 254),
            'secret' => Str::random(16), // generate secret acak 16 karakter
        ]);

        // Redirect ke halaman daftar router dengan pesan sukses
        return redirect()->route('routers.index')->with('success', 'Router berhasil ditambahkan.');
    }

    // Mengunduh script konfigurasi Mikrotik berdasarkan router tertentu
    public function downloadScript($id)
    {
        // Ambil router berdasarkan ID, jika tidak ditemukan akan error 404
        $router = Router::findOrFail($id);

        // Ambil nama user yang sedang login
        $clientName = Auth::user()->name;

        // Ambil nama router dari database
        $routerName = $router->nama_router;

        // Template script Mikrotik, berisi konfigurasi lengkap
        // Menggunakan heredoc syntax agar lebih mudah menulis multi-line string
        $script = <<<EOT
    # ============================================================
    # Konfigurasi BNC Radius Mikrotik
    # Catatan:
    # - Gunakan Notepad++ agar tidak error copy-paste di Windows 11
    # - Sesuaikan identity, secret, IP sesuai kebutuhan
    # ============================================================

    # -------- SNMP --------
    /snmp community
    set [ find default=yes ] disabled=yes write-access=no
    add addresses=172.31.192.1 name={$clientName} write-access=yes
    /snmp
    set enabled=yes trap-community={$clientName} trap-version=2

    # -------- SYSTEM --------
    /system identity
    set name="{$routerName}"

    /system clock
    set time-zone-autodetect=no time-zone-name=Asia/Makassar

    # -------- LOG --------
    /system logging disable 2

    # -------- RADIUS INCOMING --------
    /radius incoming
    set accept=yes port=3799 (port kesepekatan dari TKJ)

    # -------- DNS --------
    /ip dns
    set allow-remote-requests=yes

    # -------- NTP CLIENT --------
    /system ntp client
    set enabled=yes
    /system ntp client servers
    add address=162.159.200.1 (ip disesuaikan dengan ip client yang terdaftar)
    add address=162.159.200.123

    # -------- RADIUS SERVER --------
    /radius
    add address=172.31.192.1 \\
        comment=BNCRADIUS \\
        authentication-port=6683 \\
        accounting-port=6684 \\
        secret="a7fbbc78731904989a91" \\ 
        service=login,hotspot \\
        src-address=172.31.194.187 \\
        timeout=2s500ms

    (akses mikrotik per akun dari TKJ)
    /radius
    set require-message-auth=no

    # -------- HOTSPOT PROFILE --------
    /ip hotspot profile
    set [find] use-radius=yes radius-accounting=yes radius-interim-update=0s

    # -------- HOTSPOT USER PROFILE --------
    /ip hotspot user profile
    set [ find default=yes ] insert-queue-before=first parent-queue=*8
    add name=RLRADIUS \\
        insert-queue-before=first \\
        keepalive-timeout=10m \\
        mac-cookie-timeout=1w \\
        transparent-proxy=yes \\
        open-status-page=always \\
        shared-users=unlimited \\
        status-autorefresh=10m

    # -------- PPP PROFILE --------
    /ppp profile
    add name=RLVPN \\
        comment="default by rlradius (jangan dirubah)" \\
        change-tcp-mss=yes \\
        only-one=yes \\
        use-encryption=yes

    # -------- VPN CLIENT --------
    /interface ovpn-client
    add name=RLCLOUD \\
        connect-to=server4.rlcloud.id \\
        profile=RLVPN \\
        user=berkahbersama1221716601@rlcloud.id \\
        password=1221716601 \\
        disabled=no

    # -------- FAILOVER SCHEDULER --------
    /system scheduler
    add name=rlradiusfailover \\
        interval=7s \\
        start-date=jan/28/2023 start-time=19:41:37 \\
        policy=ftp,reboot,read,write,policy,test,password,sniff,sensitive,romon \\
        on-event="{\\
        :global intname RLCLOUD;\\
        :global indexvpn ([:pick [/system clock get time] 6 8] % 15 + 1);\\
        :global jenisvpn [/interface get \$intname type];\\
        :global address \\"server\$indexvpn.rlcloud.id\\";\\
        :local pingresult ([/ping 172.31.192.1 interface=\$intname count=5]);\\
        :if (\$pingresult = 0) do={\\
            /interface set \$intname disabled=no;\\
            :if (\$jenisvpn = \\"sstp-out\\") do={ /interface sstp-client set connect-to=\$address comment=\\"ServerVPN\$indexvpn\\" [find name=\$intname] };\\
            :if (\$jenisvpn = \\"ovpn-out\\") do={ /interface ovpn-client set connect-to=\$address comment=\\"ServerVPN\$indexvpn\\" [find name=\$intname] };\\
            :if (\$jenisvpn = \\"l2tp-out\\") do={ /interface l2tp-client set connect-to=\$address comment=\\"ServerVPN\$indexvpn\\" [find name=\$intname] };\\
        }\\
    }"
    EOT;

        // Menentukan nama file hasil download, berdasarkan ID router
        $filename = "bnc-radius-{$router->id}.rsc";

        // Mengirim file script ke browser agar langsung terunduh
        return response($script)
            ->header('Content-Type', 'text/plain') // jenis file teks
            ->header('Content-Disposition', "attachment; filename={$filename}"); // paksa unduh dengan nama file
    }
}
