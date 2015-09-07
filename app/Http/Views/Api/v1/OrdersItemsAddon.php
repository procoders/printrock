<?php

namespace App\Http\Views\Api\v1;

use App\Models as Models;
use App\Http\Views\Api\v1 as ModelViews;

/**
 * Class OrdersItemsAddon
 * @package App\Http\Views\Api\v1
 *
 * @SWG\Model(id="OrdersItemsAddon")
 */
Class OrdersItemsAddon extends BaseView
{
    /**
     * @SWG\Property(name="addon", type="Addon", required=true)
     */

    /**
     * @SWG\Property(name="qty", type="integer", required=true)
     */

    public function get()
    {
        $addonModel = $this->_model->addon()->first();

        $addonView = new ModelViews\Addon($addonModel);

        return [
            'addon' => $addonView->get(),
            'qty'   => $this->_model->qty
        ];
    }

}