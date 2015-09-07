<?php

namespace App\Http\Views\Api\v1;

use App\Models as Models;
use App\Http\Views\Api\v1 as ModelViews;

/**
 * Class OrdersItem
 * @package App\Http\Views\Api\v1
 *
 * @SWG\Model(id="OrdersItem")
 */
Class OrdersItem extends BaseView
{
    /**
     * @SWG\Property(name="id", type="integer", required=true)
     */

    /**
     * @SWG\Property(name="photo", type="Photo", required=true)
     */

    /**
     * @SWG\Property(name="qty", type="integer", required=true)
     */

    /**
     * @SWG\Property(name="price_per_item", type="integer", required=true)
     */

    /**
     * @SWG\Property(name="format", type="Format", required=true)
     */

    /**
     * @SWG\Property(name="addons", type="Addon", required=true)
     */

    public function get()
    {
        $photoModel = $this->_model->photo()->first();

        $photoView = new ModelViews\Photo($photoModel);

        $formatModel = $this->_model->format()->first();

        $formatView = new ModelViews\Format($formatModel);

        $ordersItemsAddons = [];
        foreach ($this->_model->ordersItemsAddons()->get() as $ordersItemsAddonModel) {
            $ordersItemsAddonView = new ModelViews\OrdersItemsAddon($ordersItemsAddonModel);

            $ordersItemsAddons[] = $ordersItemsAddonView->get();
        }

        return [
            'id'             => $this->_model->id,
            'photo'          => $photoView->get(),
            'qty'            => $this->_model->qty,
            'price_per_item' => $this->_model->price_per_item,
            'format'         => $formatView->get(),
            'addons'         => $ordersItemsAddons
        ];
    }

}