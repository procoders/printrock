<?php

/*
 * Describe you custom columns and form items here.
 *
 * There is some simple examples what you can use:
 *
 *		Column::register('customColumn', '\Foo\Bar\MyCustomColumn');
 *
 * 		FormItem::register('customElement', \Foo\Bar\MyCustomElement::class);
 *
 * 		FormItem::register('otherCustomElement', function (\Eloquent $model)
 * 		{
 *			AssetManager::addStyle(URL::asset('css/style-to-include-on-page-with-this-element.css'));
 *			AssetManager::addScript(URL::asset('js/script-to-include-on-page-with-this-element.js'));
 * 			if ($model->exists)
 * 			{
 * 				return 'My edit code.';
 * 			}
 * 			return 'My custom element code';
 * 		});
 */

FormItem::register('descriptions', App\AdminCustom\Forms\LanguagesFields::class);
FormItem::register('images', App\AdminCustom\Forms\ImagesFields::class);
FormItem::register('image', App\AdminCustom\Forms\ImageField::class);
FormItem::register('customTextField', App\AdminCustom\Forms\CustomTextField::class);
FormItem::register('items', App\AdminCustom\Forms\Order\Items::class);

Column::register('image', App\AdminCustom\Column\ImageColumn::class);

AdminRouter::get('/customer/photo/{id}/delete', 'App\Http\Controllers\AjaxController@deletePhoto');