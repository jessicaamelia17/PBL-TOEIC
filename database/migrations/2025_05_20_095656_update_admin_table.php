<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('admin', function (Blueprint $table) {
            $table->dropColumn(['username', 'password']); // Hapus kolom yang tidak diperlukan
            
            // Pastikan data admin tetap tersimpan dalam tabel ini
            $table->string('nama');
            $table->string('email')->unique();
            $table->string('no_hp', 15)->nullable();
        });
    }

    public function down()
    {
        Schema::table('admin', function (Blueprint $table) {
            $table->string('username')->unique();
            $table->string('password');
            $table->dropColumn(['nama', 'email', 'no_hp']);
        });
    }
};
