<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClientsGroupsTables extends Migration
{

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('groups', function(Blueprint $table) {
            $table->increments('id');
			$table->string('cod')->unique();
			$table->string('name')->unique();
            $table->timestamps();
		});

		Schema::create('clients', function(Blueprint $table) {
            $table->increments('id');
			$table->string('cod');
			$table->string('name')->unique();
			$table->integer('group_id')->unsigned();

			$table->foreign('group_id')
				->references('id')
				->on('groups')
				->onDelete('cascade');
            $table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('clients');
		Schema::drop('groups');
	}

}
