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
            // [
            //     'nim' => '2341760185',
            //     'nama' => 'Jessica Amelia',
            //     'email' => 'ameliajessica997@gmail.com',
            //     'no_hp' => '085731022917',
            //     'created_at' => now(),
            //     'updated_at' => now(),
            //     'alamat' => 'Jl. Kembang Turi No.20',
            //     'tmpt_lahir' => 'Blitar',
            //     'password' => Hash::make('jessi123'),
            // ],
            // [
            //     'nim' => '2341760066',
            //     'nama' => 'Nervalina Adzra Nora Aqilla',
            //     'email' => 'valinaadzraa@gmail.com',
            //     'no_hp' => '081357971553',
            //     'created_at' => now(),
            //     'updated_at' => now(),
            //     'alamat' => 'Jl. Soekarno Hatta Indah IV No. 21B',
            //     'tmpt_lahir' => 'Mojokerto',
            //     'password' => Hash::make('lino123'),
            // ],
            [
                'nim' => '2341760127',
                'nama' => 'Veren Regina Tirsya',
                'email' => 'verenregina214@gmail.com',
                'no_hp' => '081249135132',
                'created_at' => now(),
                'updated_at' => now(),
                'alamat' => 'Jl. Kembang Turi No.20',
                'tmpt_lahir' => 'Blitar',
                'password' => Hash::make('jessi123'),
            ],
            [
                'nim' => '2341760066',
                'nama' => 'Nervalina Adzra Nora Aqilla',
                'email' => 'valinaadzraa@gmail.com',
                'no_hp' => '081357971553',
                'created_at' => now(),
                'updated_at' => now(),
                'alamat' => 'Jl. Soekarno Hatta Indah IV No. 21B',
                'tmpt_lahir' => 'Mojokerto',
                'password' => Hash::make('linoo123'),
                'alamat' => 'Jl. Kembang Turi No.02',
                'tmpt_lahir' => 'Tulungagung',
                'password' => Hash::make('verenregina214'),
            ]
        ]);
    }
}
