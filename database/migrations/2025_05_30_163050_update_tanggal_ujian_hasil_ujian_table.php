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
            // Drop foreign key lama
            $table->dropForeign(['Tanggal_Ujian']);

            // Rename kolom
            $table->renameColumn('Tanggal_Ujian', 'id_jadwal');
        });

        Schema::table('hasil_ujian', function (Blueprint $table) {
            // Ubah tipe kolom menjadi unsignedBigInteger
            $table->unsignedBigInteger('id_jadwal')->change();

            // Tambahkan foreign key baru ke jadwal_ujian.id
            $table->foreign('id_jadwal')->references('Id_Jadwal')->on('jadwal_ujian')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('hasil_ujian', function (Blueprint $table) {
            // Hapus foreign key baru
            $table->dropForeign(['id_jadwal']);
        });

        Schema::table('hasil_ujian', function (Blueprint $table) {
            // Ubah kembali ke tipe date jika sebelumnya date
            $table->date('id_jadwal')->change();

            // Rename kembali ke Tanggal_Ujian
            $table->renameColumn('id_jadwal', 'Tanggal_Ujian');
        });

        Schema::table('hasil_ujian', function (Blueprint $table) {
            // Tambahkan kembali foreign key ke Tanggal_Ujian
            $table->foreign('Tanggal_Ujian')
                  ->references('Tanggal_Ujian')
                  ->on('jadwal_ujian')
                  ->onDelete('cascade');
        });
    }
};
