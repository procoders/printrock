<?php

use Illuminate\Database\Seeder;
use App\Models as Models;

class OrdersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		$photo = Models\Photo::find(1);
		$addon = Models\Addon::find(1);
		$format = Models\Format::find(1);

		$order = Models\Order::create([
			'customer_id' => 1,
			'orders_status_id' => $photo->price + $addon->price,
			'total' => 3
		]);

		$item = Models\OrdersItem::create([
			'order_id' => $order->id,
			'photo_id' => $photo->id,
			'qty' => 1,
			'price_per_item' => $format->price,
			'format_id' => $format->id
		]);

		Models\OrdersItemsAddon::create([
			'orders_item_id' => $item->id,
			'addon_id' => $addon->id,
			'price_per_item' => $addon->price,
			'qty' => 1
		]);
		
		Models\OrdersDelivery::create([
			'order_id' => $order->id,
			'country' => 'Germany',
			'city' => 'Munhich',
			'phone' => '755-06-6',
			'zip_code' => '41322',
			'name' => 'Alex',
			'street' => 'Morgen shtrasse'			
		]);
    }
}
