<?php

use Illuminate\Database\Seeder;
use App\Models as Models;

class FormatsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $formats = [
            ['width' => '90', 'height' => '127', 'price' => 1.5],
            ['width' => '102', 'height' => '152', 'price' => 1.5],
            ['width' => '114', 'height' => '152', 'price' => 1.7],
            ['width' => '127', 'height' => '178', 'price' => 2.02],
            ['width' => '152', 'height' => '203', 'price' => 2.02],
            ['width' => '152', 'height' => '216', 'price' => 2.02],
            ['width' => '152', 'height' => '220', 'price' => 3.02],
            ['width' => '152', 'height' => '228', 'price' => 3.02],
            ['width' => '152', 'height' => '450', 'price' => 3.02],
            ['width' => '180', 'height' => '240', 'price' => 4.00],
            ['width' => '203', 'height' => '305', 'price' => 4.00],
            ['width' => '210', 'height' => '305', 'price' => 4.00],
            ['width' => '230', 'height' => '305', 'price' => 4.00],
            ['width' => '305', 'height' => '305', 'price' => 5.00],
            ['width' => '305', 'height' => '400', 'price' => 5.00],
            ['width' => '305', 'height' => '450', 'price' => 5.00],
            ['width' => '305', 'height' => '600', 'price' => 5.00],
            ['width' => '305', 'height' => '900', 'price' => 5.00]
        ];

        foreach ($formats as $format) {
            Models\Format::create($format);
        }
    }
}
