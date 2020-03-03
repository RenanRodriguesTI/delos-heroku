<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAccountNumberColumnInUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('account_number');
        });

        $datas = [
            ['id' => '1', 'account_number' => NULL],
            ['id' => '2', 'account_number' => '002-0038'],
            ['id' => '3', 'account_number' => '01-0051'],
            ['id' => '4', 'account_number' => '002-0077'],
            ['id' => '5', 'account_number' => '002-0109'],
            ['id' => '6', 'account_number' => '01-0152'],
            ['id' => '7', 'account_number' => NULL],
            ['id' => '8', 'account_number' => '002-0075'],
            ['id' => '9', 'account_number' => NULL],
            ['id' => '10', 'account_number' => '002-0080'],
            ['id' => '11', 'account_number' => '00-0000'],
            ['id' => '12', 'account_number' => '002-0092'],
            ['id' => '13', 'account_number' => '002-0113'],
            ['id' => '14', 'account_number' => '002-0140'],
            ['id' => '15', 'account_number' => '002-0111'],
            ['id' => '16', 'account_number' => '002-0141'],
            ['id' => '17', 'account_number' => '01-0003'],
            ['id' => '18', 'account_number' => '01-0142'],
            ['id' => '19', 'account_number' => '01-0154'],
            ['id' => '20', 'account_number' => '01-0004'],
            ['id' => '21', 'account_number' => '002-0087'],
            ['id' => '22', 'account_number' => '002-0104'],
            ['id' => '23', 'account_number' => NULL],
            ['id' => '24', 'account_number' => NULL],
            ['id' => '25', 'account_number' => '01-0050'],
            ['id' => '26', 'account_number' => '002-0115'],
            ['id' => '27', 'account_number' => '01-0019'],
            ['id' => '28', 'account_number' => '01-0032'],
            ['id' => '29', 'account_number' => '01-0147'],
            ['id' => '30', 'account_number' => NULL],
            ['id' => '31', 'account_number' => '01-0151'],
            ['id' => '32', 'account_number' => '002-0127'],
            ['id' => '33', 'account_number' => '002-0116'],
            ['id' => '34', 'account_number' => '002-0094'],
            ['id' => '35', 'account_number' => '01-0148'],
            ['id' => '36', 'account_number' => '002-0122'],
            ['id' => '37', 'account_number' => '002-0131'],
            ['id' => '38', 'account_number' => '002-0088'],
            ['id' => '39', 'account_number' => '01-0149'],
            ['id' => '40', 'account_number' => '002-0114'],
            ['id' => '41', 'account_number' => '002-0130'],
            ['id' => '42', 'account_number' => '01-0153'],
            ['id' => '43', 'account_number' => NULL],
            ['id' => '44', 'account_number' => '002-0106'],
            ['id' => '45', 'account_number' => '002-0145'],
        ];

        \DB::transaction(function () use ($datas){
            foreach ($datas as $data) {
                \DB::table('users')->where('id', '=', $data['id'])->update(['account_number' => $data['account_number']]);
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
            $table->dropColumn('account_number');
        });
    }
}
