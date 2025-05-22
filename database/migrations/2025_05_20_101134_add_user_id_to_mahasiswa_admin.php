<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            // Tambahkan FK ke tabel mahasiswa
            $table->string('nim')->nullable();
            $table->foreign('nim')->references('nim')->on('mahasiswa')->onDelete('cascade');

            // Tambahkan FK ke tabel admin
            $table->unsignedBigInteger('Id_admin')->nullable();
            $table->foreign('Id_admin')->references('Id_Admin')->on('admin')->onDelete('cascade');

            // Pastikan role tetap ada untuk validasi login
            $table->enum('role', ['admin', 'mahasiswa'])->default('mahasiswa');
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['nim']);
            $table->dropColumn('nim');

            $table->dropForeign(['Id_admin']);
            $table->dropColumn('Id_admin');

            $table->dropColumn('role');
        });
    }
};
