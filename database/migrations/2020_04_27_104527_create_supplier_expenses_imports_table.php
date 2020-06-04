<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSupplierExpensesImportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('supplier_expenses_imports', function (Blueprint $table) {
            $table->increments('id');
            $table->string('project_code')->nullable();
            $table->date('issue_date');
            $table->float('value');
            $table->integer('provider_id')->unsigned();
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
        Schema::dropIfExists('supplier_expenses_imports');
    }
}
