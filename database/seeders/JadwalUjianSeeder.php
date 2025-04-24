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
                'Tanggal_Ujian' => Carbon::create(2025, 5, 10)->toDateString(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'Tanggal_Ujian' => Carbon::create(2025, 5, 17)->toDateString(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'Tanggal_Ujian' => Carbon::create(2025, 5, 24)->toDateString(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
