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
            $table->unsignedBigInteger('id_pengambilan')->nullable()->after('id_hasil');

            // Jika kamu ingin menambahkan foreign key:
            $table->foreign('id_pengambilan')
                  ->references('id_pengambilan')
                  ->on('pengambilan_sertifikat')
                  ->onDelete('set null'); // Bisa diganti cascade/restrict sesuai kebutuhan
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('riwayat_pendaftar', function (Blueprint $table) {
            $table->dropForeign(['id_pengambilan']);
            $table->dropColumn('id_pengambilan');
        });
    }
};
