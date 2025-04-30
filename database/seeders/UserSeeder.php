<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run()
    {
        // Menambahkan data pengguna admin dengan kolom name, username, dan password
        User::create([
            'name' => 'Admin User',  // Menambahkan nama
            'username' => 'admin1',
            'email' => 'admin1@example.com',  // Email bisa kamu sesuaikan
            'password' => bcrypt('12345'),  // Pastikan password di-hash
        ]);
    }
}
