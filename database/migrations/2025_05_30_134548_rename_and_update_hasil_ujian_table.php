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
            // Hapus kolom nama
            $table->dropColumn('nama');

            // Ubah nama kolom
            $table->renameColumn('listening', 'listening_1');
            $table->renameColumn('reading', 'reading_1');
            $table->renameColumn('skor', 'total_skor_1');
            $table->renameColumn('skor_2', 'total_skor_2');


        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('hasil_ujian', function (Blueprint $table) {
            // Tambahkan kembali kolom nama
            $table->string('nama')->nullable();

            // Kembalikan nama kolom seperti semula
            $table->renameColumn('listening_1', 'listening');
            $table->renameColumn('reading_1', 'reading');
            $table->renameColumn('total_skor_1', 'skor');
            $table->renameColumn('total_skor_2', 'skor_2');

        });
    }
};
