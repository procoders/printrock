<?php

namespace App\AdminCustom\Forms\Order;

use SleepingOwl\Html\HtmlBuilder;
use AssetManager;
use SleepingOwl\Admin\Models\Form\FormItem\Text;
use SleepingOwl\Admin\Models\Form\Interfaces\FormItemInterface;
use URL;
use App\Models as Models;

/**
 * Class Addons
 *
 * @package App\AdminCustom\Forms\Booking
 */
class Items extends Text implements FormItemInterface
{
    /**
     * @return string
     */
    public function render()
    {
        $model = $this->form->instance;

        $formats = [];
        foreach (Models\Format::get() as $format) {
            $formats[$format->id] = $format->width . 'x' . $format->height;
        }

        $photos = [];
        $itemsAddons = [];
        $itemsField = [];

        foreach ($model->items()->get() as $key => $item) {
            $itemsField[$key] = [
                HtmlBuilder::text('items[' . $key . '][qty]', 'Qty', $item->qty, [
                    'data-parsley-required' => true,
                    'data-parsley-type' => 'number',
                    'data-parsley-min' => '1'
                ]),
                HtmlBuilder::text('items[' . $key . '][price_per_item]', 'Price per item', $item->price_per_item, [
                    'data-parsley-required' => true,
                    'data-parsley-type' => 'number',
                ]),
                HtmlBuilder::select('items[' . $key . '][format_id]', 'Format', $formats, $item->format_id, [
                    'data-parsley-required' => true
                ]),
                $this->formBuilder->hidden('items[' . $key . '][photo_id]', $item->photo_id, [
                    'data-parsley-required' => true
                ]),
            ];
            $photos[$key] = $item->photo()->first();

            foreach ($item->ordersItemsAddons()->get() as $ordersItemsAddon) {
                $itemsAddons[$key][$ordersItemsAddon->addon_id] = $ordersItemsAddon->qty;
            }
        }

        return view('admin/form/order/items')
            ->with('label', $this->label)
            ->with('itemsField', $itemsField)
            ->with('photos', $photos)
            ->with('addons', Models\Addon::get())
            ->with('itemsAddons', $itemsAddons);
    }
}