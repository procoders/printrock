<?php

use Illuminate\Database\Seeder;
use App\Models as Models;

class LanguagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	Models\Language::create([
            'code' => 'en',
            'name' => 'English',
            'default' => true
        ]);

    	Models\Language::create([
            'code' => 'de',
            'name' => 'Deutsch'
        ]);

    	Models\Language::create([
            'code' => 'ru',
            'name' => 'Russian'
        ]);
    }
}
