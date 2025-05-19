<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('pengumuman', function (Blueprint $table) {
            $table->binary('file_pengumuman')->nullable()->after('updated_at'); // Mengubah menjadi BLOB
        });
    }

    public function down(): void
    {
        Schema::table('pengumuman', function (Blueprint $table) {
            $table->dropColumn('file_pengumuman');
        });
    }
};