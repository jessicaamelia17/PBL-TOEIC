<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('riwayat_pendaftar', function (Blueprint $table) {
            $table->id('Id_Riwayat');
            $table->unsignedBigInteger('ID_Pendaftaran')->nullable();
            $table->unsignedBigInteger('ID_Jadwal')->nullable();
            $table->unsignedBigInteger('ID_Hasil')->nullable();

            $table->foreign('ID_Pendaftaran')->references('ID_Pendaftaran')->on('pendaftaran_toeic')->onDelete('set null');
            $table->foreign('ID_Jadwal')->references('ID_Jadwal')->on('jadwal_ujian')->onDelete('set null');
            $table->foreign('ID_Hasil')->references('ID_Hasil')->on('hasil_ujian')->onDelete('set null');
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('riwayat_pendaftar');
    }
};
