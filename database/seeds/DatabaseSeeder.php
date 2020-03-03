<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(GroupsTableSeeder::class);
        $this->call(ClientsTableSeeder::class);
        $this->call(PlacesTableSeeder::class);
        $this->call(RolesTableSeeder::class);
        $this->call(PermissionsTableSeeder::class);
        $this->call(PermissionRoleTableSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(TransportationFacilitiesTableSeeder::class);
        $this->call(FinancialRatingsTableSeeder::class);
        $this->call(ProjectTypesTableSeeder::class);
        $this->call(CarTypesTableSeeder::class);
        $this->call(HotelRoomsTableSeeder::class);
        $this->call(StatesTableSeeder::class);
        $this->call(AirportsTableSeeder::class);
        $this->call(CitiesTableSeeder::class);
        $this->call(TasksTableSeeder::class);
        $this->call(ProjectsTableSeeder::class);
        $this->call(HolidaysTableSeeder::class);
        $this->call(ExpensesTableSeeder::class);
        $this->call(DebitMemosTableSeeder::class);
    }
}
