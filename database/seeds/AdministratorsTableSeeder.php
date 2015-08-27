<?php

use Illuminate\Database\Seeder;
use App\Models as Models;

class AdministratorsTableSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
//        foreach (Models\Administrator::all() as $admin) {
//            $admin->delete();
//        }

        Models\Administrator::create([
            'username' => 'admin',
            'password' => Hash::make('admin'),
            'name' => 'Administrator'
        ]);
    }

}
