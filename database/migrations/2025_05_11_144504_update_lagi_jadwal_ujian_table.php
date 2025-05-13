<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Pindahkan kolom kuota_terpakai agar setelah kuota_max
        DB::statement("ALTER TABLE jadwal_ujian MODIFY kuota_max INT DEFAULT 5 AFTER Tanggal_Ujian");
        DB::statement("ALTER TABLE jadwal_ujian MODIFY kuota_terpakai INT DEFAULT 0 AFTER kuota_max");
        
    }

    public function down(): void
    {
        // (Opsional) kamu bisa balikan posisi kolom kalau perlu
    }
};
