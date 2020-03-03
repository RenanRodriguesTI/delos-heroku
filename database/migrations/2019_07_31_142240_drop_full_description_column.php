<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DropFullDescriptionColumn extends Migration
{

    public function up()
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->dropColumn('full_description');
        });
    }

    public function down()
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->string('full_description', 1024);
        });
    }
}
