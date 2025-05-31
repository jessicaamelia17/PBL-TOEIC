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
            $table->string('NIM', 20)->after('Id_Hasil');
            $table->foreign('NIM')->references('nim')->on('mahasiswa')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pengambilan_sertifikat', function (Blueprint $table) {
            $table->dropForeign(['NIM']);
            $table->dropColumn('NIM');
        });
    }
};
