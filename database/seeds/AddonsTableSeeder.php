<?php

use Illuminate\Database\Seeder;
use App\Models as Models;

class AddonsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $addons = [
            [
                'name' => 'Remove red eyes',
                'price_type' => 'price',
                'price' => 1.00,
                'addon_type' => 'photo_operation',
                'image' => ''
            ],
            [
                'name' => 'Remove glare',
                'price_type' => 'percent',
                'price' => 10,
                'addon_type' => 'photo_operation',
                'image' => ''
            ],
            [
                'name' => 'Wood border',
                'price_type' => 'price',
                'price' => 7.00,
                'addon_type' => 'photo_frames',
                'image' => '/addons/wood_border.jpg'
            ],
            [
                'name' => 'Steel border',
                'price_type' => 'price',
                'price' => 9.00,
                'addon_type' => 'photo_frames',
                'image' => '/addons/steel_border.jpg'
            ]
        ];

        foreach ($addons as $addon) {
            $addonModel = Models\Addon::create([
                'name' => $addon['name'],
                'image' => $addon['image'],
                'price_type' => $addon['price_type'],
                'price' => $addon['price'],
                'addons_type_id' => Models\AddonsType::where('code', $addon['addon_type'])->first()->id
            ]);
        }

    }
}
