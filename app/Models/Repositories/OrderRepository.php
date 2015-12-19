<?php

namespace App\Models\Repositories;

use App\Models\Repositories\Interfaces as Interfaces;
use App\Models as Models;
use Illuminate\Database\Eloquent\Model;

/**
 * Class OrderRepository
 *
 * @package App\Models\Repositories
 */
Class OrderRepository implements Interfaces\iAdminSave
{
    protected $model = null;

    /**
     * @param \App\Models\Order $model
     */
    public function __construct(Models\Order $model)
    {
        $this->model = $model;
        return $this;
    }

    public function fillOrderPrices($data)
    {
        foreach ($data['items'] as $itemKey => $item) {
            if ($this->model->id < 1 || (!isset($item['format_price']))) {
                $data['items'][$itemKey]['format_price'] = Models\Format::find($item['format_id'])->first()->price;
            }

            foreach ($item['addons'] as $addonKey => $addon) {
                if ($this->model->id < 1) {
                    $data['items'][$itemKey]['addons'][$addonKey]['addon_price'] = Models\Addon::find($addon['id'])
                        ->first()
                        ->price;
                }
            }
        }

        // calculate total price
        if ($this->model->id < 1 || empty($data['total'])) {
            $total = 0;

            foreach ($data['items'] as $item) {
                $total += $item['qty'] * $item['format_price'];

                foreach ($item['addons'] as $addon) {
                    $total += $addon['addon_price']*$addon['qty'];
                }
            }

            $data['total'] = $total;
        }
        return $data;
    }

    /**
     * @param array $attributes
     */
    public function saveFromArray(array $attributes = array())
    {
        $attributes = $this->fillOrderPrices($attributes);

        $this->model->customer_id = $attributes['customer_id'];

        /**
         * TODO: add status history
         */
        if (! isset($attributes['orders_status_id'])) {
            $ordersStatus = Models\OrdersStatus::where('default', true)->first();
            $this->model->orders_status_id = $ordersStatus->id;
        } else {
            $this->model->orders_status_id = $attributes['orders_status_id'];
        }

        $this->model->total = $attributes['total'];
        $this->model->comment = $attributes['comment'];

        $this->model->save();

        $this->model->items()->delete();
        foreach ($attributes['items'] as $oredersItem) {
            $item = new Models\OrdersItem();

            $item->order_id = $this->model->id;
            $item->photo_id = $oredersItem['photo_id'];
            $item->qty = $oredersItem['qty'];
            $item->format_id = $oredersItem['format_id'];
            $item->format_price = $oredersItem['format_price'];

            $item->save();

            foreach ($oredersItem['addons'] as $oredersItemsAddon) {
                if (isset($oredersItemsAddon['id']) && $oredersItemsAddon['id']) {
                    $orderAddon = new Models\OrdersItemsAddon();
                    $addon = Models\Addon::find($oredersItemsAddon['id']);

                    $orderAddon->orders_item_id = $item->id;
                    $orderAddon->addon_id = $addon->id;
                    $orderAddon->addon_price = $oredersItemsAddon['addon_price'];
                    $orderAddon->qty = $oredersItemsAddon['qty'];

                    $orderAddon->save();
                }
            }
        }
        if ($attributes['delivery']) {
            $delivery = new Models\OrdersDelivery();
            $delivery->order_id = $this->model->id;
            $delivery->country = $attributes['delivery']['country'];
            $delivery->city = $attributes['delivery']['city'];
            $delivery->phone = $attributes['delivery']['phone'];
            $delivery->zip_code = $attributes['delivery']['zip_code'];
            $delivery->street = $attributes['delivery']['street'];
            $delivery->name = $attributes['delivery']['name'];
            $delivery->save();
        }
    }

}