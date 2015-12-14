<?php

use Illuminate\Database\Seeder;
use App\Models as Models;

class CustomersAddressTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		$customersAddress = [
			[
				"customer_id" => 1,
				"country" => "Germany",
				"city" => "Munhich",
				"phone" => "755-06-6",
				"zip_code" => "41322",
				"name" => "Alex",
				"street" => "Morgen shtrasse"
			],
			[
				"customer_id" => 1,
				"country" => "Germany",
				"city" => "Munhich",
				"phone" => "755-06-44",
				"zip_code" => "41321",
				"name" => "Ronald",
				"street" => "Morgen shtrasse"
			],
			[
				"customer_id" => 2,
				"country" => "Germany",
				"city" => "Munhich",
				"phone" => "755-06-44",
				"zip_code" => "41321",
				"name" => "Wolter",
				"street" => "Morgen shtrasse"
			]
		];

		foreach ($customersAddress as $address) {
			Models\CustomersAddress::create([
				"customer_id" => $address["customer_id"],
				"country" => $address["country"],
				"city" => $address["city"],
				"phone" => $address["phone"],
				"zip_code" => $address["zip_code"],
				"name" => $address["name"],
				"street" => $address["street"],
			]);
		}
    }
}
