<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'name' => 'user',
                'telepon' => '0801',
                'password' => Hash::make('user'),
                'level' => 'user',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'admin',
                'telepon' => '0802',
                'password' => Hash::make('admin'),
                'level' => 'admin',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'administrator',
                'telepon' => '0803',
                'password' => Hash::make('administrator'),
                'level' => 'administrator',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'teknisi',
                'telepon' => '0804',
                'password' => Hash::make('teknisi'),
                'level' => 'teknisi',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'keuangan',
                'telepon' => '0805',
                'password' => Hash::make('keuangan'),
                'level' => 'keuangan',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'operator',
                'telepon' => '0806',
                'password' => Hash::make('operator'),
                'level' => 'operator',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
