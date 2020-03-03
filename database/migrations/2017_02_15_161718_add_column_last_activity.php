<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnLastActivity extends Migration
{
    public function up()
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->timestamp('last_activity')
                ->nullable()
                ->after('finish');
        });
    }

    public function down()
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->dropColumn('last_activity');
        });
    }
}
