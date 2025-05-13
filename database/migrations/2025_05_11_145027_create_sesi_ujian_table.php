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
        Schema::create('sesi_ujian', function (Blueprint $table) {
            $table->id('id_sesi');
            $table->unsignedBigInteger('id_jadwal');
            $table->string('nama_sesi');
            $table->time('waktu_mulai');
            $table->time('waktu_selesai');
            $table->timestamps();

            $table->foreign('id_jadwal')->references('id_jadwal')->on('jadwal_ujian')->onDelete('cascade');
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sesi_ujian');
    }
};
