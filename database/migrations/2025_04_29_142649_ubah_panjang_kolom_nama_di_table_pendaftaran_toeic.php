<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('pendaftaran_toeic', function (Blueprint $table) {
            $table->string('email', 100)->change();
        });
    }

    public function down(): void
    {
        Schema::table('pendaftaran_toeic', function (Blueprint $table) {
            $table->string('email', 25)->change();
        });
    }
};

