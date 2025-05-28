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
            // Drop foreign keys jika ada
            if (Schema::hasColumn('pendaftaran_toeic', 'id_jurusan')) {
                $table->dropForeign(['id_jurusan']);
                $table->dropColumn('id_jurusan');
            }

            if (Schema::hasColumn('pendaftaran_toeic', 'id_prodi')) {
                $table->dropForeign(['id_prodi']);
                $table->dropColumn('id_prodi');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pendaftaran_toeic', function (Blueprint $table) {
            // Tambahkan kembali kolom jika rollback
            $table->unsignedBigInteger('id_jurusan')->nullable();
            $table->unsignedBigInteger('id_prodi')->nullable();

            // Tambahkan kembali FK jika dibutuhkan
            $table->foreign('id_jurusan')->references('id')->on('jurusan')->onDelete('set null');
            $table->foreign('id_prodi')->references('id')->on('prodi')->onDelete('set null');
        });
    }
};
