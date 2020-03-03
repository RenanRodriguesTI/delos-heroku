<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSupplierNumbersColumnInUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('supplier_number')
                ->nullable()
                ->unique();
        });

        $datas = [
            ['id' => '2', 'supplier_number' => '002-0038'],
            ['id' => '3', 'supplier_number' => '01-0051-1073'],
            ['id' => '4', 'supplier_number' => '002-0077-1123'],
            ['id' => '5', 'supplier_number' => '002-0109-1354'],
            ['id' => '6', 'supplier_number' => '01-0152'],
            ['id' => '8', 'supplier_number' => '002-0018'],
            ['id' => '10', 'supplier_number' => '002-0080-1149'],
            ['id' => '11', 'supplier_number' => '01-0000'],
            ['id' => '12', 'supplier_number' => '002-0092-1024'],
            ['id' => '13', 'supplier_number' => '002-0113-1214'],
            ['id' => '14', 'supplier_number' => '002-0140-1370'],
            ['id' => '15', 'supplier_number' => '002-0111-1115'],
            ['id' => '16', 'supplier_number' => '002-0141-1362'],
            ['id' => '17', 'supplier_number' => '01-0003'],
            ['id' => '18', 'supplier_number' => '01-0142-1107'],
            ['id' => '19', 'supplier_number' => '002-0105-1073'],
            ['id' => '20', 'supplier_number' => '01-0004'],
            ['id' => '21', 'supplier_number' => '002-0087-1081'],
            ['id' => '22', 'supplier_number' => '002-0104-1131'],
            ['id' => '23', 'supplier_number' => '002-0107-1172'],
            ['id' => '25', 'supplier_number' => '01-0050-1057'],
            ['id' => '26', 'supplier_number' => '002-0115-1339'],
            ['id' => '27', 'supplier_number' => '01-0019-1040'],
            ['id' => '28', 'supplier_number' => '01-0032-1032'],
            ['id' => '29', 'supplier_number' => '01-0147-1115'],
            ['id' => '31', 'supplier_number' => '01-0151-1164'],
            ['id' => '32', 'supplier_number' => '002-0127-1313'],
            ['id' => '33', 'supplier_number' => '002-0116-1347'],
            ['id' => '34', 'supplier_number' => '002-0094-1164'],
            ['id' => '35', 'supplier_number' => '01-0148-1149'],
            ['id' => '36', 'supplier_number' => '002-0122-1321'],
            ['id' => '37', 'supplier_number' => '002-0131-1297'],
            ['id' => '38', 'supplier_number' => '002-0088-1099'],
            ['id' => '39', 'supplier_number' => '01-0149-1156'],
        ];

        \DB::transaction(function () use ($datas) {
            foreach ($datas as $data) {
                \DB::table('users')->where('id', $data['id'])->update(['supplier_number' => $data['supplier_number']]);
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
            $table->dropColumn('supplier_number');
        });
    }
}
