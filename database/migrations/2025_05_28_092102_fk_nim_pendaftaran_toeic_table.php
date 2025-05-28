<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('pendaftaran_toeic', function (Blueprint $table) {
            // Pastikan kolom nim bertipe string dan cocok dengan mahasiswa.nim
            $table->string('NIM')->change(); // Ubah jika perlu

            // Tambahkan foreign key ke tabel mahasiswa
            $table->foreign('NIM')->references('nim')->on('mahasiswa')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pendaftaran_toeic', function (Blueprint $table) {
            // Hapus relasi foreign key jika di-rollback
            $table->dropForeign(['nim']);
        });
    }
};
