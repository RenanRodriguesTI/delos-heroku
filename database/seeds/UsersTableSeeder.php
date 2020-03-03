<?php

use Illuminate\Database\Seeder;
use Delos\Dgp\Entities\User;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(User::class)->create([
            'name' => 'Administrador',
            'email' => 'administrador@delosservicos.com.br',
            'password' => bcrypt('E5l2a1i9!'),
            'admission' => Carbon::now()->toDateString(),
            'role_id' => DB::table('roles')->select()->where('slug', 'root')->value('id'),
        ]);

        factory(User::class)->create([
            'name' => 'Flavio Silva',
            'email' => 'flavio.silva@delosservicos.com.br',
            'password' => bcrypt('123456'),
            'admission' => Carbon::now()->toDateString(),
            'role_id' => DB::table('roles')->select()->where('slug', 'collaborator')->value('id'),
        ]);

        factory(User::class)->create([
            'name' => 'Dhales Ribeiro',
            'email' => 'dhales.ribeiro@delosservicos.com.br',
            'password' => bcrypt('123456'),
            'admission' => Carbon::now()->toDateString(),
            'role_id' => DB::table('roles')->select()->where('slug', 'collaborator')->value('id'),
        ]);

        factory(User::class, 9)->create();
    }
}
