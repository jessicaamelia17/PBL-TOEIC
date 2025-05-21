<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAlamatPhotoTtlToMahasiswaTable extends Migration
{
    public function up()
    {
        Schema::table('mahasiswa', function (Blueprint $table) {
            $table->string('alamat')->nullable();
            $table->string('photo')->nullable();
            $table->string('tmpt_lahir')->nullable();
            $table->date('TTL')->nullable();
        });
    }

    public function down()
    {
        Schema::table('mahasiswa', function (Blueprint $table) {
            $table->dropColumn(['alamat', 'photo', 'TTL']);
        });
    }
}
