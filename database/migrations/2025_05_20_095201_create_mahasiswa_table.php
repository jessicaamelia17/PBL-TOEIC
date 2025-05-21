<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('mahasiswa', function (Blueprint $table) {
            $table->string('nim')->primary(); // NIM sebagai Primary Key
            $table->string('nama');
            $table->string('email')->unique();
            $table->string('no_hp', 15)->nullable();
            $table->foreignId('Id_Jurusan')->constrained('jurusan')->onDelete('cascade'); // FK ke tabel jurusan
            $table->foreignId('Id_Prodi')->constrained('prodi')->onDelete('cascade'); // FK ke tabel prodi
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('mahasiswa');
    }
};