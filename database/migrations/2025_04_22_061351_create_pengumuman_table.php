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
    public function up()
    {
        Schema::create('pengumuman', function (Blueprint $table) {
            $table->id('Id_Pengumuman');
            $table->string('Judul', 255);
            $table->text('Isi');
            $table->dateTime('Tanggal_Pengumuman')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->unsignedBigInteger('Created_By')->nullable();

            // Jika pakai admin
            $table->foreign('Created_By')->references('Id_Admin')->on('admin')->onDelete('set null');
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengumuman');
    }
};
