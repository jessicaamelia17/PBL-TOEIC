<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('pendaftaran_toeic', function (Blueprint $table) {
            // Hapus kolom yang redundant karena sudah ada di tabel mahasiswa
            if (Schema::hasColumn('pendaftaran_toeic', 'nama')) {
                $table->dropColumn('nama');
            }
            if (Schema::hasColumn('pendaftaran_toeic', 'no_wa')) {
                $table->dropColumn('no_wa');
            }
            if (Schema::hasColumn('pendaftaran_toeic', 'email')) {
                $table->dropColumn('email');
            }
        });
    }

    public function down()
    {
        Schema::table('pendaftaran_toeic', function (Blueprint $table) {
            // Tambahkan kembali kolom yang dihapus jika rollback
            $table->string('nama')->nullable();
            $table->string('no_wa')->nullable();
            $table->string('email')->nullable();
        });
    }
};
