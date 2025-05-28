<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('surat_pengajuan', function (Blueprint $table) {
            $table->string('file_sertifikat')->nullable()->after('status_verifikasi');
        });
    }

    public function down(): void
    {
        Schema::table('surat_pengajuan', function (Blueprint $table) {
            $table->dropColumn('file_sertifikat');
        });
    }
};
