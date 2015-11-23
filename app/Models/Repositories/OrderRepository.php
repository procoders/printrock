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

    /**
     * @param array $attributes
     */
    public function saveFromArray(array $attributes = array())
    {
        $this->model->customer_id = $attributes['customer_id'];

        if (! isset($attributes['orders_status_id'])) {
            $ordersStatus = Models\OrdersStatus::where('default', 1)->first();
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
            $item->price_per_item = $oredersItem['price_per_item'];

            $item->save();

            foreach ($oredersItem['addons'] as $oredersItemsAddon) {
                if (isset($oredersItemsAddon['id']) && $oredersItemsAddon['id']) {
                    $addon = new Models\OrdersItemsAddon();

                    $addon->orders_item_id = $item->id;
                    $addon->addon_id = $oredersItemsAddon['id'];
                    $addon->qty = $oredersItemsAddon['qty'];

                    $addon->save();
                }
            }
        }
    }

}