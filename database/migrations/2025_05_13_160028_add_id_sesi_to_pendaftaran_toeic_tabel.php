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
        Schema::table('pendaftaran_toeic', function (Blueprint $table) {
            $table->unsignedBigInteger('id_sesi')->nullable()->after('id_room');
            $table->foreign('id_sesi')->references('id_sesi')->on('sesi_ujian')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pendaftaran_toeic', function (Blueprint $table) {
            $table->dropForeign(['id_sesi']);
            $table->dropColumn('id_sesi');
        });
    }
};
