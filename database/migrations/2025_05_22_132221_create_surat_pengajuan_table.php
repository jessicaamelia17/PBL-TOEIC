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
        Schema::create('surat_pengajuan', function (Blueprint $table) {
            $table->id('id_surat');
            $table->string('NIM', 20); // relasi ke mahasiswa berdasarkan NIM
            $table->date('tanggal_pengajuan');
            $table->enum('status_verifikasi', ['menunggu', 'disetujui', 'ditolak'])->default('menunggu');
            $table->date('tanggal_verifikasi')->nullable();
            $table->text('catatan')->nullable();
            $table->timestamps();

            // Jika ada tabel mahasiswa, bisa tambahkan foreign key opsional
            $table->foreign('NIM')->references('NIM')->on('mahasiswa')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('surat_pengajuan');
    }
};
