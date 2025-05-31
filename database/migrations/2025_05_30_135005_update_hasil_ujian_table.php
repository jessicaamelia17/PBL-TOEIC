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
        Schema::table('hasil_ujian', function (Blueprint $table) {
            // Pastikan kolom nim bertipe string dan cocok dengan mahasiswa.nim
            $table->string('NIM')->change(); // Ubah jika perlu

            // // Tambahkan foreign key ke tabel mahasiswa
            $table->foreign('NIM')->references('nim')->on('mahasiswa')->onDelete('cascade');


             // Tambahkan foreign key ke jadwal_ujian
             $table->date('Tanggal_Ujian')->change();

             $table->foreign('Tanggal_Ujian')
                   ->references('Tanggal_Ujian')
                   ->on('jadwal_ujian')
                   ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('hasil_ujian', function (Blueprint $table) {
            // Hapus relasi foreign key jika di-rollback
            $table->dropForeign(['nim']);
            $table->dropForeign(['Tanggal_Ujian']);
        });
    }
};
