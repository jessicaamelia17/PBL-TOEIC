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
        Schema::create('room_ujian', function (Blueprint $table) {
            $table->id('id_room');
            $table->unsignedBigInteger('id_sesi');
            $table->string('nama_room'); // contoh: Room 1
            $table->string('zoom_id');
            $table->string('zoom_password');
            $table->timestamps();

            // foreign key ke sesi_ujian
            $table->foreign('id_sesi')->references('id_sesi')->on('sesi_ujian')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('room_ujian');
    }
};
