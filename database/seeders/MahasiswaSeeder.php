<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class MahasiswaSeeder extends Seeder
{
    public function run()
    {
        DB::table('mahasiswa')->insert([
            // [
            //     'nim' => '2341760133',
            //     'nama' => 'Bagas Pratama',
            //     'email' => 'bagas@example.com',
            //     'no_hp' => '081234567890',
            //     'created_at' => now(),
            //     'updated_at' => now(),
            //     'alamat' => 'Jl. Raya Blimbing No. 99',
            //     'tmpt_lahir' => 'Malang',
            //     'password' => Hash::make('bagas123'),
            // ],
            [
                'nim' => '2341760132',
                'nama' => 'Athallah Fauzan',
                'email' => 'athafauzan@example.com',
                'no_hp' => '081298765432',
                'created_at' => now(),
                'updated_at' => now(),
                'alamat' => 'Jl. Moh. Hatta No. 100',
                'tmpt_lahir' => 'Gresik',
                'password' => Hash::make('atha1234'),
            ]
        ]);
    }
}
