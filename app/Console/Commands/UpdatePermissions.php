<?php

namespace Delos\Dgp\Console\Commands;

use Delos\Dgp\Entities\GroupCompany;
use Delos\Dgp\Repositories\Contracts\UserRepository;
use Illuminate\Console\Command;

class UpdatePermissions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:permissions';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update Permissions table and your relatives from Model Factory';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->cleanTable();

        $this->updateFromModelFactory();

        $this->updateUsersRole();
    }

    private function cleanTable(): void
    {
        \DB::statement('SET FOREIGN_KEY_CHECKS=0');

        \DB::table('permissions')->truncate();
        \DB::table('roles')->truncate();
        \DB::table('permission_role')->truncate();
        \DB::table('module_permission')->truncate();

        \DB::statement('SET FOREIGN_KEY_CHECKS=1');
    }

    private function updateFromModelFactory(): void
    {
        app(\PermissionsTableSeeder::class)->run();
        app(\RolesTableSeeder::class)->run();
        app(\PermissionRoleTableSeeder::class)->run();
        app(\ModulePermissionTableSeeder::class)->run();
    }

    private function updateUsersRole(): void
    {
        foreach (app(GroupCompany::class)->all() as $groupCompany) {

            session(['groupCompanies' => [$groupCompany->id]]);
            session(['companies' => $groupCompany->companies()->pluck('id')->toArray()]);

            $users = app(UserRepository::class)->all();

            foreach ($users as $user) {
                $permissions = $user->role->permissions;
                $user->permissions()->sync($permissions);
            }
        }
    }
}
