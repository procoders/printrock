<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $this->call(AdministratorsTableSeeder::class);
        $this->call(LanguagesTableSeeder::class);
        $this->call(OrdersStatusTableSeeder::class);
        $this->call(FormatsTableSeeder::class);
        $this->call(AddonTypesTableSeeder::class);
        $this->call(AddonsTableSeeder::class);
        $this->call(CustomersTableSeeder::class);
        $this->call(CustomersAddressTableSeeder::class);
        $this->call(OrdersTableSeeder::class);

        Model::reguard();
    }
}
