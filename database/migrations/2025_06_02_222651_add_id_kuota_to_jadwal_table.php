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
    public function up(): void
    {
        Schema::table('jadwal_ujian', function (Blueprint $table) {
            $table->unsignedBigInteger('id_kuota')->nullable()->after('kuota_terpakai'); // nullable sementara
        });
    
        // Isi default id_kuota dulu dari data kuota yang ada
        DB::table('jadwal_ujian')->update([
            'id_kuota' => 1 // <-- sesuaikan ID kuota default kamu
        ]);
    
        // Baru tambahkan foreign key constraint
        Schema::table('jadwal_ujian', function (Blueprint $table) {
            $table->foreign('id_kuota')
                ->references('id')->on('kuota')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('jadwal_ujian', function (Blueprint $table) {
            $table->dropForeign(['id_kuota']);
            $table->dropColumn('id_kuota');
        });
    }
};
