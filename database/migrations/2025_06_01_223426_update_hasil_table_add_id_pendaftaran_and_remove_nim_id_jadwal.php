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
            // Hapus foreign key dan kolom NIM jika ada relasinya
            if (Schema::hasColumn('hasil_ujian', 'NIM')) {
                $table->dropForeign(['NIM']); // jika ada FK
                $table->dropColumn('NIM');
            }

            // Hapus foreign key dan kolom id_jadwal jika ada relasinya
            if (Schema::hasColumn('hasil_ujian', 'id_jadwal')) {
                $table->dropForeign(['id_jadwal']); // jika ada FK
                $table->dropColumn('id_jadwal');
            }

            // Tambahkan kolom Id_Pendaftaran
            $table->unsignedBigInteger('Id_Pendaftaran')->after('Id_Hasil');

            // Tambahkan foreign key
            $table->foreign('Id_Pendaftaran')->references('Id_Pendaftaran')->on('pendaftaran_toeic')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('hasil_ujian', function (Blueprint $table) {
            //Kembalikan kolom NIM
            $table->string('NIM', 255)->after('Id_Hasil');

            // Kembalikan kolom id_jadwal
            $table->unsignedBigInteger('id_jadwal')->after('NIM');

            // Tambahkan kembali foreign key jika diperlukan (sesuaikan nama tabel/kolom)
            $table->foreign('NIM')->references('NIM')->on('mahasiswa')->onDelete('cascade');
            $table->foreign('id_jadwal')->references('id_jadwal')->on('jadwal')->onDelete('cascade');

            // Hapus kolom Id_Pendaftaran
            $table->dropForeign(['Id_Pendaftaran']);
            $table->dropColumn('Id_Pendaftaran');
        });
    }
};
