<?php

namespace App\Http\Controllers;

use App\Models\Router;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class RouterController extends Controller
{
    public function index()
    {
        $routers = Router::all();
        return view('admin-sub.routers.index', compact('routers'));
    }

    public function create()
    {
        return view('admin-sub.routers.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_router' => 'required|string|max:255',
            'tipe_koneksi' => 'required|in:ip_public,vpn_radius',
            'ip_address' => 'nullable|ip'
        ]);

        Router::create([
            'nama_router' => $request->nama_router,
            'tipe_koneksi' => $request->tipe_koneksi,
            'ip_address' => $request->tipe_koneksi === 'ip_public'
                ? $request->ip_address
                : '172.31.' . rand(0, 255) . '.' . rand(1, 254), // IP default random jika VPN RADIUS
            'secret' => Str::random(16),
        ]);

        return redirect()->route('routers.index')->with('success', 'Router berhasil ditambahkan.');
    }

    public function downloadScript($id)
    {
        $router = Router::findOrFail($id);

        // ambil nama user & router
        $clientName = Auth::user()->name;
        $routerName = $router->nama_router;

        // template script dengan inject variabel
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

        // kasih nama file sesuai router
        $filename = "bnc-radius-{$router->id}.rsc";

        return response($script)
            ->header('Content-Type', 'text/plain')
            ->header('Content-Disposition', "attachment; filename={$filename}");
    }
}
