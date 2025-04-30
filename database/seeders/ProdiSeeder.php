<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProdiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
            // Contoh ambil id jurusan dari nama
    $jurusan = DB::table('jurusan')->pluck('Id_Jurusan', 'Nama_Jurusan');

    DB::table('prodi')->insert([
        ['Nama_Prodi' => 'D-III Teknik Kimia', 'Id_Jurusan' => $jurusan['Teknik Kimia']],
        ['Nama_Prodi' => 'D-IV Teknologi Kimia Industri', 'Id_Jurusan' => $jurusan['Teknik Kimia']],
        ['Nama_Prodi' => 'D-IV Teknik Kimia', 'Id_Jurusan' => $jurusan['Teknik Kimia']],
        ['Nama_Prodi' => 'D-IV Sistem Kelistrikan', 'Id_Jurusan' => $jurusan['Teknik Elektro']],
        ['Nama_Prodi' => 'D-IV Teknik Elektronika', 'Id_Jurusan' => $jurusan['Teknik Elektro']],
        ['Nama_Prodi' => 'D-IV Sistem Kelistrikan', 'Id_Jurusan' => $jurusan['Teknik Elektro']],
        ['Nama_Prodi' => 'D-IV Teknik Jaringan Telekomunikasi Digital', 'Id_Jurusan' => $jurusan['Teknik Elektro']],
        ['Nama_Prodi' => 'D-III Teknik Elektronika', 'Id_Jurusan' => $jurusan['Teknik Elektro']],
        ['Nama_Prodi' => 'D-III Teknik Listrik', 'Id_Jurusan' => $jurusan['Teknik Elektro']],
        ['Nama_Prodi' => 'D-III Teknik Telekomunikasi', 'Id_Jurusan' => $jurusan['Teknik Elektro']],
        ['Nama_Prodi' => 'D-IV Teknik Elektronika PSDKU Kota Kediri', 'Id_Jurusan' => $jurusan['Teknik Elektro']],
        ['Nama_Prodi' => 'D-IV Manajemen Rekayasa Konstruksi', 'Id_Jurusan' => $jurusan['Teknik Sipil']],
        ['Nama_Prodi' => 'D-IV Teknologi Rekayasa Konstruksi Jalan dan Jembatan', 'Id_Jurusan' => $jurusan['Teknik Sipil']],
        ['Nama_Prodi' => 'D-III Teknologi Konstruksi Jalan, Jembatan, dan Bangunan Air', 'Id_Jurusan' => $jurusan['Teknik Sipil']],
        ['Nama_Prodi' => 'D-III Teknologi Pertambangan', 'Id_Jurusan' => $jurusan['Teknik Sipil']],
        ['Nama_Prodi' => 'D-III Teknik Sipil', 'Id_Jurusan' => $jurusan['Teknik Sipil']],
        ['Nama_Prodi' => 'D-III Teknologi Sipil PSDKU Kab. Lumajang', 'Id_Jurusan' => $jurusan['Teknik Sipil']],
        ['Nama_Prodi' => 'D-IV Teknik Mesin', 'Id_Jurusan' => $jurusan['Teknik Mesin']],
        ['Nama_Prodi' => 'D-IV Teknik Informatika', 'Id_Jurusan' => $jurusan['Teknologi Informasi']],
        ['Nama_Prodi' => 'D-IV Sistem Informasi Bisnis', 'Id_Jurusan' => $jurusan['Teknologi Informasi']],
        ['Nama_Prodi' => 'D-II Pengembangan Piranti Lunak Situsi', 'Id_Jurusan' => $jurusan['Teknologi Informasi']],
        ['Nama_Prodi' => 'D-III Manajemen Informatika PSDKU Kota Kediri', 'Id_Jurusan' => $jurusan['Teknologi Informasi']],
        ['Nama_Prodi' => 'D-III Manajemen Informatika PSDKU Kab. Pamekasan', 'Id_Jurusan' => $jurusan['Teknologi Informasi']],
        ['Nama_Prodi' => 'D-III Teknologi Informasi PSDKU Kab. Lumajang', 'Id_Jurusan' => $jurusan['Teknologi Informasi']],
        ['Nama_Prodi' => 'D-IV Teknik Mesin Produksi dan Perawatan', 'Id_Jurusan' => $jurusan['Teknik Mesin']],
        ['Nama_Prodi' => 'D-IV Teknik Otomotif Elektronik', 'Id_Jurusan' => $jurusan['Teknik Mesin']],
        ['Nama_Prodi' => 'D-III Teknik Mesin', 'Id_Jurusan' => $jurusan['Teknik Mesin']],
        ['Nama_Prodi' => 'D-III Teknologi Pemeliharaan Pesawat Udara', 'Id_Jurusan' => $jurusan['Teknik Mesin']],
        ['Nama_Prodi' => 'D-IV Teknik Mesin Produksi dan Perawatan PSDKU Kota Kediri', 'Id_Jurusan' => $jurusan['Teknik Mesin']],
        ['Nama_Prodi' => 'D-IV Teknologi Rekayasa Otomotif PSDKU Kab. Lumajang', 'Id_Jurusan' => $jurusan['Teknik Mesin']],
        ['Nama_Prodi' => 'D-IV Teknik Otomotif Elektronik PSDKU Kab. Pamekasan', 'Id_Jurusan' => $jurusan['Teknik Mesin']],
        ['Nama_Prodi' => 'D-IV Bahasa Inggris untuk Komunikasi Bisnis dan Profesional', 'Id_Jurusan' => $jurusan['Administrasi Niaga']],
        ['Nama_Prodi' => 'D-IV Manajemen Pemasaran', 'Id_Jurusan' => $jurusan['Administrasi Niaga']],
        ['Nama_Prodi' => 'D-IV Pengelolaan Arsip dan Rekaman Informasi', 'Id_Jurusan' => $jurusan['Administrasi Niaga']],
        ['Nama_Prodi' => 'D-IV Usaha Perjalanan Wisata', 'Id_Jurusan' => $jurusan['Administrasi Niaga']],
        ['Nama_Prodi' => 'D-IV Bahasa Inggris untuk Industri Pariwisata', 'Id_Jurusan' => $jurusan['Administrasi Niaga']],
        ['Nama_Prodi' => 'D-III Administrasi Bisnis', 'Id_Jurusan' => $jurusan['Administrasi Niaga']],
        ['Nama_Prodi' => 'D-IV Akuntansi Manajemen', 'Id_Jurusan' => $jurusan['Akuntansi']],
        ['Nama_Prodi' => 'D-IV Keuangan', 'Id_Jurusan' => $jurusan['Akuntansi']],
        ['Nama_Prodi' => 'D-III Akuntansi', 'Id_Jurusan' => $jurusan['Akuntansi']],
        ['Nama_Prodi' => 'D-IV Keuangan PSDKU Kota Kediri', 'Id_Jurusan' => $jurusan['Akuntansi']],
        ['Nama_Prodi' => 'D-III Akuntansi PSDKU Kota Kediri', 'Id_Jurusan' => $jurusan['Akuntansi']],
        ['Nama_Prodi' => 'D-III Akuntansi PSDKU Kab. Lumajang', 'Id_Jurusan' => $jurusan['Akuntansi']],
        ['Nama_Prodi' => 'D-III Akuntansi PSDKU Kab. Pamekasan', 'Id_Jurusan' => $jurusan['Akuntansi']],
       
        // Tambahkan prodi lainnya sesuai kebutuhan
    ]);
    }
}
