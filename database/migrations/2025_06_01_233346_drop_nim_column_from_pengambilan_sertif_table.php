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
        Schema::table('pengambilan_sertifikat', function (Blueprint $table) {
                        // Hapus foreign key dulu (jika ada)
                        $table->dropForeign(['NIM']);

                        // Baru hapus kolomnya
                        $table->dropColumn('NIM');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pengambilan_sertifikat', function (Blueprint $table) {
                        // Tambahkan kembali kolom NIM
            $table->string('NIM', 20);

            // Tambahkan kembali foreign key-nya
            $table->foreign('NIM')->references('NIM')->on('mahasiswa')->onDelete('cascade');
        
        });
    }
};
