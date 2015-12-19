<?php

namespace App\Http\Views\Api\v1;

use App\Models as Models;
use App\Http\Views\Api\v1 as ModelViews;

/**
 * Class OrdersItemsCalculateBody
 * @package App\Http\Views\Api\v1
 *
 * @SWG\Model(id="OrdersItemsCalculateBody")
 */
Class OrdersItemsCalculateBody extends BaseView
{

    /**
     * @SWG\Property(name="qty", type="integer", required=true)
     */

    /**
     * @SWG\Property(name="format_id", type="integer", required=true)
     */

    /**
     * @SWG\Property(name="addons", type="array", @SWG\Items("OrdersItemsAddonsCalculateBody"), required=true)
     */

    public function get()
    {
        $ordersItemsAddonsBodyModel = new SleepingOwlModel();

        $ordersItemsAddonsBodyView = new ModelViews\OrdersItemsAddonsCalculateBody($ordersItemsAddonsBodyModel);

        $addons = [
            $ordersItemsAddonsBodyView->get()
        ];

        return [
            'qty'            => 0,
            'format_id'      => 0,
            'addons'         => $addons
        ];
    }

}