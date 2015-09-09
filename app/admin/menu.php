<?php

/*
 * Describe your menu here.
 *
 * There is some simple examples what you can use:
 *
 * 		Admin::menu()->url('/')->label('Start page')->icon('fa-dashboard')->uses('\AdminController@getIndex');
 * 		Admin::menu(User::class)->icon('fa-user');
 * 		Admin::menu()->label('Menu with subitems')->icon('fa-book')->items(function ()
 * 		{
 * 			Admin::menu(\Foo\Bar::class)->icon('fa-sitemap');
 * 			Admin::menu('\Foo\Baz')->label('Overwrite model title');
 * 			Admin::menu()->url('my-page')->label('My custom page')->uses('\MyController@getMyPage');
 * 		});
 */

Admin::menu(\App\Models\Administrator::class)->label('Administrator')->icon('fa-user');


Admin::menu()->label('Customers')->icon('fa-user')->items(function ()
{
    Admin::menu(\App\Models\Customer::class)->label('Customers');
    Admin::menu(\App\Models\CustomersAddress::class)->label('Addresses');
});

Admin::menu(\App\Models\Language::class)->label('Languages')->icon('fa-language');

Admin::menu()->label('Orders')->icon('fa-book')->items(function ()
{
    Admin::menu(\App\Models\OrdersStatus::class)->label('Statuses');
    Admin::menu(\App\Models\Order::class)->label('Orders');
    Admin::menu(\App\Models\OrdersItem::class)->label('Items');
});

Admin::menu()->label('Addons')->icon('fa-book')->items(function ()
{
    Admin::menu(\App\Models\AddonsType::class)->label('Type');
    Admin::menu(\App\Models\Addon::class)->label('Addons');
});

Admin::menu(\App\Models\Format::class)->label('Formats')->icon('fa-file-image-o');