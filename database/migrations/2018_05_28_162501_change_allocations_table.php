<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeAllocationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('allocations', function (Blueprint $table) {
            $table->renameColumn('notes', 'description');

        });

        Schema::table('allocations', function (Blueprint $table) {
            $table->longtext('description')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('allocations', function (Blueprint $table) {
            $table->renameColumn('description', 'notes');

        });

        Schema::table('allocations', function (Blueprint $table) {
            $table->string('description', 255)->change();
        });
    }
}
