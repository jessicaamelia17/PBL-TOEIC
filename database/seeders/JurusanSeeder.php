<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JurusanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
            DB::table('jurusan')->insert([
        ['Nama_Jurusan' => 'Teknik Kimia'],
        ['Nama_Jurusan' => 'Teknik Elektro'],
        ['Nama_Jurusan' => 'Teknik Sipil'],
        ['Nama_Jurusan' => 'Teknologi Informasi'],
        ['Nama_Jurusan' => 'Teknik Mesin'],
        ['Nama_Jurusan' => 'Administrasi Niaga'],
        ['Nama_Jurusan' => 'Akuntansi'],
    ]);
    }
}
