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
        Schema::table('riwayat_pendaftar', function (Blueprint $table) {
                    // Hapus foreign key constraint terlebih dahulu
                    $table->dropForeign(['ID_Jadwal']);

                    // Hapus kolom ID_Jadwal
                    $table->dropColumn('ID_Jadwal');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('riwayat_pendaftar', function (Blueprint $table) {
             // Tambahkan kembali kolom ID_Jadwal
             $table->unsignedBigInteger('ID_Jadwal')->nullable();

             // Tambahkan kembali foreign key
             $table->foreign('ID_Jadwal')->references('id')->on('jadwal');
        });
    }
};
