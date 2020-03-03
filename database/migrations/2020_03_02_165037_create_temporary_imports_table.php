<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTemporaryImportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('temporary_imports', function (Blueprint $table) {
            $table->increments('id');
            $table->string('project_code')->nullable();
            $table->string('os')->nullable();
            $table->string('status')->nullable();
            $table->string('description')->nullable();
            $table->date('date_migration');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('temporary_imports');
    }
}
