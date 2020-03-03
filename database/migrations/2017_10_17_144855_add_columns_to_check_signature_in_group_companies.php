<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsToCheckSignatureInGroupCompanies extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('group_companies', function (Blueprint $table) {
            $table->date('billing_date')->nullable();
            $table->date('signature_date')->nullable();
            $table->boolean('is_defaulting')->nullable();
            $table->boolean('plan_status')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('group_companies', function (Blueprint $table) {
            $table->dropColumn([
                'billing_date',
                'signature_date',
                'is_defaulting',
                'plan_status'
            ]);
        });
    }
}
