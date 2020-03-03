<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSellerIdAndCommissionColumnsOnProjectsTable extends Migration
{

    public function up()
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->unsignedInteger('seller_id')
                ->nullable(true);

            $table->foreign('seller_id')
                ->references('id')
                ->on('users');

            $table->decimal('commission', 10,2)
                ->nullable(true);

        });
    }

    public function down()
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->dropForeign('projects_seller_id_foreign');
            $table->dropColumn('seller_id');
            $table->dropColumn('commission');
        });
    }
}
