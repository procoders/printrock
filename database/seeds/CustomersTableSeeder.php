<?php

use Illuminate\Database\Seeder;
use App\Models as Models;

class CustomersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		$customers = [
			[
				"name" => "Bob",
				"second_name" => "Alan",
				"last_name" => "Martin",
				"email" => "bob@gmail.com",
				"phone" => "455-055-33",
				"login" => "bobby",
				"password" => "bobby"
			],
			[
				"name" => "Alex",
				"second_name" => "Volter",
				"last_name" => "Smit",
				"email" => "smit@gmail.com",
				"phone" => "477-035-31",
				"login" => "smit",
				"password" => "smit"
			]
		];

		foreach ($customers as $customer) {
			$customer = Models\Customer::create([
				"name" => $customer["name"],
				"second_name" => $customer["second_name"],
				"last_name" => $customer["last_name"],
				"email" => $customer["email"],
				"phone" => $customer["phone"],
				"login" => $customer["login"],
				"password" => $customer["password"],
			]);

			if ($customer->id == 1) {
				Models\Photo::create([
					'customer_id' => $customer->id,
					'image' => 'seeder_wedding.jpg'
				]);
			}
		}
    }
}
