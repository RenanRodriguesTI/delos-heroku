<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddHasBilledAndInvoiceNumberAndNotesColumnsInProjectProposalValues extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('project_proposal_values', function (Blueprint $table) {
            $table->boolean('has_billed');
            $table->string('invoice_number');
            $table->string('notes');           
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {   
        Schema::disableForeignKeyConstraints();
        Schema::drop('project_proposal_values');
        Schema::enableForeignKeyConstraints();
    }
}
