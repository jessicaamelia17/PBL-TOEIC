<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AdminSeeder extends Seeder
{
    public function run()
    {
        DB::table('admin')->insert([
            [
                'nama'       => 'Admin1 TOEIC',
                'email'      => 'admin1@toeic.com',
                'no_hp'      => '081234567890',
                'username'   => 'admin1',
                'password'   => bcrypt('admin123'), // menggunakan bcrypt
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}
