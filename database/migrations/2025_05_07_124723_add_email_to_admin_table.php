<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddEmailToAdminTable extends Migration
{
    public function up()
    {
        Schema::table('admin', function (Blueprint $table) {
            $table->string('email')->unique()->after('username');
        });
    }

    public function down()
    {
        Schema::table('admin', function (Blueprint $table) {
            $table->dropColumn('email');
        });
    }
}
