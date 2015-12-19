<?php

use Illuminate\Database\Seeder;
use App\Models as Models;

class AddonTypesTableSeeder extends Seeder
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
        $addonType = Models\AddonsType::create([
            'code' => 'photo_operation',
        ]);

        $names = [
            'en' => 'Operations under the photo',
            'de' => 'Maßnahmen im Rahmen des Foto',
            'ru' => 'Операции над фото'
        ];

        foreach ($languages as $code => $id) {
            Models\AddonsTypesDescription::create([
                'language_id' => $id,
                'addons_type_id' => $addonType->id,
                'name' => $names[$code]
            ]);
        }

        $addonType = Models\AddonsType::create([
            'code' => 'photo_frames',
        ]);

        $names = [
                'en' => 'Put photo into the frame',
                'de' => 'Setzen Foto in den Rahmen',
                'ru' => 'Поставить фото в рамку'
        ];

        foreach ($languages as $code => $id) {
            Models\AddonsTypesDescription::create([
                'language_id' => $id,
                'addons_type_id' => $addonType->id,
                'name' => $names[$code]
            ]);
        }
    }
}
