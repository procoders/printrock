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

        $languages = [
            'en' => Models\Language::where('code', 'en')->first()->id,
            'de' => Models\Language::where('code', 'de')->first()->id,
            'ru' => Models\Language::where('code', 'ru')->first()->id,
        ];
        $addons = [
            [
                'name' => [
                    'en' => 'Remove red eyes',
                    'de' => 'Rote Augen entfernen',
                    'ru' => 'Убрать красные глаза',
                ],
                'price_type' => 'price',
                'price' => 1.00,
                'addon_type' => 'photo_operation',
                'image' => ''
            ],
            [
                'name' => [
                    'en' => 'Remove glare',
                    'de' => 'entfernen Blendung',
                    'ru' => 'Убрать блики',
                ],
                'price_type' => 'percent',
                'price' => 10,
                'addon_type' => 'photo_operation',
                'image' => ''
            ],
            [
                'name' => [
                    'en' => 'Wood border',
                    'de' => 'Hölzerner Rand',
                    'ru' => 'Деревянная рамка',
                ],
                'price_type' => 'price',
                'price' => 7.00,
                'addon_type' => 'photo_frames',
                'image' => '/addons/wood_border.jpg'
            ],
            [
                'name' => [
                    'en' => 'Steel border',
                    'de' => 'Stahlgrenz',
                    'ru' => 'Металлическая рамка',
                ],
                'price_type' => 'price',
                'price' => 9.00,
                'addon_type' => 'photo_frames',
                'image' => '/addons/steel_border.jpg'
            ]
        ];

        foreach ($addons as $addon) {
            $addonModel = Models\Addon::create([
                //'name' => $addon['name'],
                'image' => $addon['image'],
                'price_type' => $addon['price_type'],
                'price' => $addon['price'],
                'addons_type_id' => Models\AddonsType::where('code', $addon['addon_type'])->first()->id
            ]);

            foreach ($languages as $code => $id) {
                Models\AddonsDescription::create([
                    'language_id' => $id,
                    'addon_id' => $addonModel->id,
                    'name' =>  $addon['name'][$code]
                ]);
            }
        }

    }
}
