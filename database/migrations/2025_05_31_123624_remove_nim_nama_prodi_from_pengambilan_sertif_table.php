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
            $table->dropColumn(['NIM', 'Nama', 'Program_Studi']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pengambilan_sertifikat', function (Blueprint $table) {
            $table->string('NIM', 255)->nullable();
            $table->string('Nama', 255)->nullable();
            $table->string('Program_Studi', 255)->nullable();
        });
    }
};
