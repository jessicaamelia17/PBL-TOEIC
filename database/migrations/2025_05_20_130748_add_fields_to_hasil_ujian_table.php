<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('hasil_ujian', function (Blueprint $table) {
            // Tambahkan kolom nama, listening, reading
            $table->string('Nama')->after('NIM')->nullable();
            $table->integer('Listening')->after('Nama')->nullable()->check('Listening BETWEEN 0 AND 495');
            $table->integer('Reading')->after('Listening')->nullable()->check('Reading BETWEEN 0 AND 495');

            // Tambahkan kolom listening_2, reading_2, skor_2
            $table->integer('Listening_2')->after('Skor')->nullable()->check('Listening_2 BETWEEN 0 AND 495');
            $table->integer('Reading_2')->after('Listening_2')->nullable()->check('Reading_2 BETWEEN 0 AND 495');
            $table->integer('Skor_2')->after('Reading_2')->nullable()->check('Skor_2 BETWEEN 0 AND 990');
        });
    }

    public function down(): void
    {
        Schema::table('hasil_ujian', function (Blueprint $table) {
            $table->dropColumn([
                'Nama',
                'Listening',
                'Reading',
                'Listening_2',
                'Reading_2',
                'Skor_2',
            ]);
        });
    }
};