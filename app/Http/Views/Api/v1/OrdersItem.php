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
     * @SWG\Property(name="format_price", type="double", required=true)
     */

    /**
     * @SWG\Property(name="format", type="Format", required=true)
     */

    /**
     * @SWG\Property(name="addons", type="OrdersItemsAddon", required=true)
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
            'format_price'   => $this->_model->format_price,
            'format'         => $formatView->get(),
            'addons'         => $ordersItemsAddons
        ];
    }

}