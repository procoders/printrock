<?php

namespace App\Http\Views\Api\v1;

use App\Models as Models;
use App\Http\Views\Api\v1 as ModelViews;

/**
 * Class OrdersItemsBody
 * @package App\Http\Views\Api\v1
 *
 * @SWG\Model(id="OrdersItemsBody")
 */
Class OrdersItemsBody extends BaseView
{
    /**
     * @SWG\Property(name="photo_id", type="integer", required=true)
     */

    /**
     * @SWG\Property(name="qty", type="integer", required=true)
     */

    /**
     * @SWG\Property(name="format_id", type="integer", required=true)
     */

    /**
     * @SWG\Property(name="addons", type="array", @SWG\Items("OrdersItemsAddonsBody"), required=true)
     */

    public function get()
    {
        $ordersItemsAddonsBodyModel = new SleepingOwlModel();

        $ordersItemsAddonsBodyView = new ModelViews\OrdersItemsAddonsBody($ordersItemsAddonsBodyModel);

        $addons = [
            $ordersItemsAddonsBodyView->get()
        ];

        return [
            'photo_id'       => 0,
            'qty'            => 0,
            'price_per_item' => 0,
            'format_id'      => 0,
            'addons'         => $addons
        ];
    }

}