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

        Models\AddonsType::create([
            'code' => 'photo_operation',
            'name' => 'Operations under the photo'
        ]);

        Models\AddonsType::create([
            'code' => 'photo_frames',
            'name' => 'Put photo into the frame'
        ]);
    }
}
