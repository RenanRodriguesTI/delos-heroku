<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCompanyIdInUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->unsignedInteger('company_id')->nullable();
            $table->foreign('company_id')
                    ->references('id')
                        ->on('companies')
                            ->onDelete('cascade')
                                ->onUpdate('cascade');
        });

        $datas = [
            ['id' => '2', 'company_id' => '1'],
            ['id' => '3', 'company_id' => '2'],
            ['id' => '4', 'company_id' => '1'],
            ['id' => '5', 'company_id' => '2'],
            ['id' => '6', 'company_id' => '2'],
            ['id' => '7', 'company_id' => '2'],
            ['id' => '8', 'company_id' => '1'],
            ['id' => '9', 'company_id' => '2'],
            ['id' => '10', 'company_id' => '1'],
            ['id' => '11', 'company_id' => '2'],
            ['id' => '12', 'company_id' => '1'],
            ['id' => '13', 'company_id' => '1'],
            ['id' => '14', 'company_id' => '1'],
            ['id' => '15', 'company_id' => '1'],
            ['id' => '16', 'company_id' => '1'],
            ['id' => '17', 'company_id' => '2'],
            ['id' => '18', 'company_id' => '2'],
            ['id' => '19', 'company_id' => '2'],
            ['id' => '20', 'company_id' => '2'],
            ['id' => '21', 'company_id' => '1'],
            ['id' => '22', 'company_id' => '1'],
            ['id' => '23', 'company_id' => '1'],
            ['id' => '24', 'company_id' => '2'],
            ['id' => '25', 'company_id' => '2'],
            ['id' => '26', 'company_id' => '1'],
            ['id' => '27', 'company_id' => '2'],
            ['id' => '28', 'company_id' => '2'],
            ['id' => '29', 'company_id' => '2'],
            ['id' => '31', 'company_id' => '2'],
            ['id' => '32', 'company_id' => '1'],
            ['id' => '33', 'company_id' => '1'],
            ['id' => '34', 'company_id' => '1'],
            ['id' => '35', 'company_id' => '2'],
            ['id' => '36', 'company_id' => '1'],
            ['id' => '37', 'company_id' => '1'],
            ['id' => '38', 'company_id' => '1'],
            ['id' => '39', 'company_id' => '2'],
            ['id' => '40', 'company_id' => '1'],
            ['id' => '41', 'company_id' => '1'],
        ];

        \DB::transaction(function () use ($datas){
            foreach ($datas as $data) {
                \DB::table('users')->where('id', '=', $data['id'])->update(['company_id' => $data['company_id']]);
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign('users_company_id_foreign');
        });
    }
}
