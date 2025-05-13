<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pendaftaran_toeic', function (Blueprint $table) {
            $table->unsignedBigInteger('id_room')->nullable()->after('ID_Jadwal');

            $table->foreign('id_room')->references('id_room')->on('room_ujian')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('pendaftaran_toeic', function (Blueprint $table) {
            $table->dropForeign(['id_room']);
            $table->dropColumn('id_room');
        });
    }
};
