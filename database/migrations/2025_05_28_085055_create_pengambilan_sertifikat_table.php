<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pengambilan_sertifikat', function (Blueprint $table) {
            $table->id('id_pengambilan');
            $table->unsignedBigInteger('Id_Hasil'); // foreign key ke hasil_ujian
            $table->string('NIM');
            $table->string('Nama');
            $table->string('Program_Studi');
            $table->date('Tanggal_Diambil')->nullable();
            $table->enum('Status', ['Diambil', 'Belum Diambil'])->default('Belum Diambil');
            $table->timestamps();

            // Relasi foreign key ke hasil_ujian
            $table->foreign('Id_Hasil')
                ->references('Id_Hasil') // pastikan nama kolom di tabel hasil_ujian
                ->on('hasil_ujian')
                ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pengambilan_sertifikat');
    }
};