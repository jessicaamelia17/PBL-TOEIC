<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class JadwalUjianSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('jadwal_ujian')->insert([
            [
                'Tanggal_Ujian' => Carbon::create(2025, 7, 17)->toDateString(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'Tanggal_Ujian' => Carbon::create(2025, 7, 18)->toDateString(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'Tanggal_Ujian' => Carbon::create(2025, 7, 19)->toDateString(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'Tanggal_Ujian' => Carbon::create(2025, 7, 20)->toDateString(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'Tanggal_Ujian' => Carbon::create(2025, 7, 21)->toDateString(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'Tanggal_Ujian' => Carbon::create(2025, 7, 22)->toDateString(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'Tanggal_Ujian' => Carbon::create(2025, 7, 23)->toDateString(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'Tanggal_Ujian' => Carbon::create(2025, 7, 24)->toDateString(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'Tanggal_Ujian' => Carbon::create(2025, 7, 25)->toDateString(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
