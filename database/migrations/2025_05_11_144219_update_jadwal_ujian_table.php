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
        Schema::table('jadwal_ujian', function (Blueprint $table) {
            // Ubah nama kolom 'kuota' jadi 'kuota_max' jika sebelumnya ada
            if (Schema::hasColumn('jadwal_ujian', 'kuota')) {
                $table->renameColumn('kuota', 'kuota_max');
            } else {
                $table->integer('kuota_max')->default(5);
            }

            // Tambahkan kolom kuota_terpakai
            if (!Schema::hasColumn('jadwal_ujian', 'kuota_terpakai')) {
                $table->integer('kuota_terpakai')->default(0);
            }

            // Ubah default status_registrasi jika perlu
            $table->enum('status_registrasi', ['buka', 'tutup'])->default('buka')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('jadwal_ujian', function (Blueprint $table) {
            // Kembalikan perubahan jika diperlukan
            if (Schema::hasColumn('jadwal_ujian', 'kuota_max')) {
                $table->renameColumn('kuota_max', 'kuota');
            }

            $table->dropColumn('kuota_terpakai');

            $table->enum('status_registrasi', ['buka', 'tutup'])->default('tutup')->change();
        });
    }
};
