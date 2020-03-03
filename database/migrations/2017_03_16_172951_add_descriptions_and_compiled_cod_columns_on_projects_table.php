<?php

use Delos\Dgp\Entities\Project;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDescriptionsAndCompiledCodColumnsOnProjectsTable extends Migration
{

    public function up()
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->string('compiled_cod')->nullable()->after('cod');
            $table->string('description')->nullable()->after('compiled_cod');
            $table->string('full_description')->nullable()->after('description');
        });

        $projects = Project::withTrashed()->get();
        foreach($projects as $project) {
            $project->save();
        }
    }


    public function down()
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->dropColumn('compiled_cod');
            $table->dropColumn('description');
            $table->dropColumn('full_description');
        });
    }
}
