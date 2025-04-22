<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('pendaftaran_toeic', function (Blueprint $table) {
            $table->id('Id_Pendaftaran');
            $table->string('NIM', 20)->unique();
            $table->string('Nama', 100);
            $table->string('No_WA', 15);
            $table->string('email', 25);
            $table->unsignedBigInteger('Id_Jurusan')->nullable();
            $table->unsignedBigInteger('Id_Prodi')->nullable();
            $table->binary('Scan_KTP')->nullable();
            $table->binary('Scan_KTM')->nullable();
            $table->binary('Pas_Foto')->nullable();
            $table->dateTime('Tanggal_Pendaftaran')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->unsignedBigInteger('ID_Jadwal')->nullable();

            $table->foreign('Id_Jurusan')->references('Id_Jurusan')->on('jurusan')->onDelete('set null');
            $table->foreign('Id_Prodi')->references('Id_Prodi')->on('prodi')->onDelete('set null');
            $table->foreign('ID_Jadwal')->references('ID_Jadwal')->on('jadwal_ujian')->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pendaftaran_toeic');
    }
};
