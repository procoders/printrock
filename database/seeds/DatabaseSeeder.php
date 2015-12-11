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

        Model::reguard();
    }
}
