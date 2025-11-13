<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PaketSeeder extends Seeder
{
    /**
     * Jalankan seeder untuk tabel paket.
     */
    public function run(): void
    {
        DB::table('pakets')->insert([
            [
                'id' => 1,
                'nama' => 'Basic',
                'harga_bulanan' => 100000,
                'mikrotik' => 3,
                'langganan' => 200,
                'voucher' => 5000,
                'user_online' => 250,
                'vpn_tunnel' => 1,
                'vpn_remote' => 0,
                'whatsapp_gateway' => 0,
                'payment_gateway' => 0,
                'custom_domain' => 0,
                'client_area' => 0,
                'harga_tahunan' => 1000000,
                'created_at' => null,
                'updated_at' => null,
            ],
            [
                'id' => 2,
                'nama' => 'Premium',
                'harga_bulanan' => 290000,
                'mikrotik' => 10,
                'langganan' => 500,
                'voucher' => 300000,
                'user_online' => 600,
                'vpn_tunnel' => 1,
                'vpn_remote' => 1,
                'whatsapp_gateway' => 1,
                'payment_gateway' => 1,
                'custom_domain' => 1,
                'client_area' => 1,
                'harga_tahunan' => 3000000,
                'created_at' => null,
                'updated_at' => null,
            ],
            [
                'id' => 3,
                'nama' => 'Ultimate',
                'harga_bulanan' => 475000,
                'mikrotik' => 15,
                'langganan' => 700,
                'voucher' => 50000,
                'user_online' => 850,
                'vpn_tunnel' => 1,
                'vpn_remote' => 1,
                'whatsapp_gateway' => 1,
                'payment_gateway' => 1,
                'custom_domain' => 1,
                'client_area' => 1,
                'harga_tahunan' => 4500000,
                'created_at' => null,
                'updated_at' => null,
            ],
        ]);
    }
}
