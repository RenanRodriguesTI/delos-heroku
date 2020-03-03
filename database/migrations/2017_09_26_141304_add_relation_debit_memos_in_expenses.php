<?php

use Delos\Dgp\Entities\Expense;
use Delos\Dgp\Entities\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddRelationDebitMemosInExpenses extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('expenses', function (Blueprint $table) {
            $table->unsignedInteger('debit_memo_id')->nullable();
            $table->foreign('debit_memo_id')->references('id')->on('debit_memos');

            $table->unsignedInteger('project_id')->nullable();
            $table->foreign('project_id')->references('id')->on('projects')->onDelete('cascade');

            $table->integer('request_id')->unsigned()->nullable()->change();
        });

        foreach (Expense::all() as $expense) {
            $expense->update([
                'project_id' => $expense->request->project->id,
                'debit_memo_id' => $expense->request->debitMemo->id ?? null
            ]);
        }

        Schema::table('requests', function (Blueprint $table) {
            $this->dropDebitMemoForeign($table);
            $table->dropColumn('debit_memo_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('requests', function (Blueprint $table) {
            $table->unsignedInteger('debit_memo_id')->nullable();
            $table->foreign('debit_memo_id')->references('id')->on('debit_memos');
        });

        foreach (Expense::all() as $expense) {
            $expense->request()->update([
                'debit_memo_id' => $expense->debitMemo->id ?? null
            ]);
        }

        Schema::table('expenses', function (Blueprint $table) {
            $table->dropForeign(['debit_memo_id']);
            $table->dropColumn('debit_memo_id');

            $table->dropForeign(['project_id']);
            $table->dropColumn('project_id');
        });
    }

    private function existsForeignKey($table, $foreignKey)
    {
        $conn = Schema::getConnection()->getDoctrineSchemaManager();

        $foreignKeys = array_map(function($key) {
            return $key->getName();
        }, $conn->listTableForeignKeys($table));

        return in_array($foreignKey, $foreignKeys);
    }

    private function dropDebitMemoForeign(Blueprint $table)
    {
        if ($this->existsForeignKey('requests', 'requests_ibfk_1')) {
            $table->dropForeign('requests_ibfk_1');
        }else {
            $table->dropForeign(['debit_memo_id']);
        }
    }
}
