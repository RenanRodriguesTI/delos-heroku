<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddNewPermission extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $data = ['slug' =>'change-hours-ps-project','name'=>'Change Hours PS Project'];
        $dataroles= ["collaborator","manager","administrative","administrator","root","client","comercial"];   
        \DB::transaction(function () use ($data,$dataroles){
            \DB::table('permissions')->insert($data);
            $permission = \DB::select('select * from permissions where slug =:slug', ['slug' => $data['slug']]);
            foreach($dataroles as $role){
                $results = \DB::select('select * from roles where slug =:slug', ['slug' => $role]);
               
                if(!empty($results) && !empty($permission)){
                    \DB::table('permission_role')->insert(['role_id'=>$results[0]->id,'permission_id'=>$permission[0]->id]);
                }
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
        $data = ['slug' =>'change-hours-ps-project','name'=>'Change Hours PS Project'];
        $dataroles= ["collaborator","manager","administrative","administrator","root","client","comercial"];   
        \DB::transaction(function () use ($data,$dataroles){
            $permission = \DB::table('permissions')->where('slug', '=',$data['slug'])->first();

            if(!empty($permission)){
                foreach($dataroles as $role){
                    $results =  \DB::table('roles')->where('slug', '=',$role)->first();
                   
                    if(!empty($results) && !empty($permission)){
                       
                     \DB::table('permission_role')->where('role_id', '=', $results->id)->where('permission_id', '=', $permission->id)->delete();
                    }
                }
                \DB::table('permissions')->where('slug', '=',$data['slug'])->delete();
            }
           
            
        });
    }
}
