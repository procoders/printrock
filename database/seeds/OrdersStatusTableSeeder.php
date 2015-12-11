<?php

use Illuminate\Database\Seeder;
use App\Models as Models;

class OrdersStatusTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $ordersStatus = Models\OrdersStatus::create([
        	'code' => 'new',
        	'default' => true
    	]);
    	Models\OrdersStatusesDescription::create([
    		'language_id' => Models\Language::where('code', 'en')->first()->id,
    		'name' => 'New',
    		'orders_status_id' => $ordersStatus->id
		]);
    	Models\OrdersStatusesDescription::create([
    		'language_id' => Models\Language::where('code', 'de')->first()->id,
    		'name' => 'Neue',
    		'orders_status_id' => $ordersStatus->id
		]);
    	Models\OrdersStatusesDescription::create([
    		'language_id' => Models\Language::where('code', 'ru')->first()->id,
    		'name' => 'Новый',
    		'orders_status_id' => $ordersStatus->id
		]);

        $ordersStatus = Models\OrdersStatus::create([
        	'code' => 'payment',
        	'default' => false
    	]);
    	Models\OrdersStatusesDescription::create([
    		'language_id' => Models\Language::where('code', 'en')->first()->id,
    		'name' => 'Payment',
    		'orders_status_id' => $ordersStatus->id
		]);
    	Models\OrdersStatusesDescription::create([
    		'language_id' => Models\Language::where('code', 'de')->first()->id,
    		'name' => 'Zahlung',
    		'orders_status_id' => $ordersStatus->id
		]);
    	Models\OrdersStatusesDescription::create([
    		'language_id' => Models\Language::where('code', 'ru')->first()->id,
    		'name' => 'Ожидается оплата',
    		'orders_status_id' => $ordersStatus->id
		]);

        $ordersStatus = Models\OrdersStatus::create([
        	'code' => 'payment_confirmed',
        	'default' => false
    	]);
    	Models\OrdersStatusesDescription::create([
    		'language_id' => Models\Language::where('code', 'en')->first()->id,
    		'name' => 'Payment confirmed',
    		'orders_status_id' => $ordersStatus->id
		]);
    	Models\OrdersStatusesDescription::create([
    		'language_id' => Models\Language::where('code', 'de')->first()->id,
    		'name' => 'Bezahlung bestätigt',
    		'orders_status_id' => $ordersStatus->id
		]);
    	Models\OrdersStatusesDescription::create([
    		'language_id' => Models\Language::where('code', 'ru')->first()->id,
    		'name' => 'Оплачен',
    		'orders_status_id' => $ordersStatus->id
		]);

        $ordersStatus = Models\OrdersStatus::create([
        	'code' => 'printed',
        	'default' => false
    	]);
    	Models\OrdersStatusesDescription::create([
    		'language_id' => Models\Language::where('code', 'en')->first()->id,
    		'name' => 'Printed',
    		'orders_status_id' => $ordersStatus->id
		]);
    	Models\OrdersStatusesDescription::create([
    		'language_id' => Models\Language::where('code', 'de')->first()->id,
    		'name' => 'Gedruckt',
    		'orders_status_id' => $ordersStatus->id
		]);
    	Models\OrdersStatusesDescription::create([
    		'language_id' => Models\Language::where('code', 'ru')->first()->id,
    		'name' => 'Распечатан',
    		'orders_status_id' => $ordersStatus->id
		]);

        $ordersStatus = Models\OrdersStatus::create([
        	'code' => 'delivery',
        	'default' => false
    	]);
    	Models\OrdersStatusesDescription::create([
    		'language_id' => Models\Language::where('code', 'en')->first()->id,
    		'name' => 'Delivery',
    		'orders_status_id' => $ordersStatus->id
		]);
    	Models\OrdersStatusesDescription::create([
    		'language_id' => Models\Language::where('code', 'de')->first()->id,
    		'name' => 'Lieferung',
    		'orders_status_id' => $ordersStatus->id
		]);
    	Models\OrdersStatusesDescription::create([
    		'language_id' => Models\Language::where('code', 'ru')->first()->id,
    		'name' => 'Доставка',
    		'orders_status_id' => $ordersStatus->id
		]);

        $ordersStatus = Models\OrdersStatus::create([
        	'code' => 'delivery_confirmed',
        	'default' => false
    	]);
    	Models\OrdersStatusesDescription::create([
    		'language_id' => Models\Language::where('code', 'en')->first()->id,
    		'name' => 'Delivered',
    		'orders_status_id' => $ordersStatus->id
		]);
    	Models\OrdersStatusesDescription::create([
    		'language_id' => Models\Language::where('code', 'de')->first()->id,
    		'name' => 'Geliefert',
    		'orders_status_id' => $ordersStatus->id
		]);
    	Models\OrdersStatusesDescription::create([
    		'language_id' => Models\Language::where('code', 'ru')->first()->id,
    		'name' => 'Доставлен',
    		'orders_status_id' => $ordersStatus->id
		]);

       	$ordersStatus = Models\OrdersStatus::create([
        	'code' => 'closed',
        	'default' => false
    	]);
    	Models\OrdersStatusesDescription::create([
    		'language_id' => Models\Language::where('code', 'en')->first()->id,
    		'name' => 'Closed',
    		'orders_status_id' => $ordersStatus->id
		]);
    	Models\OrdersStatusesDescription::create([
    		'language_id' => Models\Language::where('code', 'de')->first()->id,
    		'name' => 'Geschlossen',
    		'orders_status_id' => $ordersStatus->id
		]);
    	Models\OrdersStatusesDescription::create([
    		'language_id' => Models\Language::where('code', 'ru')->first()->id,
    		'name' => 'Закрыт',
    		'orders_status_id' => $ordersStatus->id
		]);

        $ordersStatus = Models\OrdersStatus::create([
        	'code' => 'cancelled',
        	'default' => false
    	]);
    	Models\OrdersStatusesDescription::create([
    		'language_id' => Models\Language::where('code', 'en')->first()->id,
    		'name' => 'Cancelled',
    		'orders_status_id' => $ordersStatus->id
		]);
    	Models\OrdersStatusesDescription::create([
    		'language_id' => Models\Language::where('code', 'de')->first()->id,
    		'name' => 'Abgebrochen',
    		'orders_status_id' => $ordersStatus->id
		]);
    	Models\OrdersStatusesDescription::create([
    		'language_id' => Models\Language::where('code', 'ru')->first()->id,
    		'name' => 'Отменен',
    		'orders_status_id' => $ordersStatus->id
		]); 	

    }
}
