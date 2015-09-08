<?php

namespace App\Http\Views\Api\v1;

use App\Models as Models;
use App\Http\Views\Api\v1 as ModelViews;

/**
 * Class OrdersBody
 * @package App\Http\Views\Api\v1
 *
 * @SWG\Model(id="OrdersBody")
 */
Class OrdersBody extends BaseView
{
    /**
     * @SWG\Property(name="customer_id", type="integer", required=true)
     */

    /**
     * @SWG\Property(name="total", type="integer", required=true)
     */

    /**
     * @SWG\Property(name="items", type="array", @SWG\Items("OrdersItemsBody"), required=true)
     */

    public function get()
    {
        $ordersItemsBodyModel = new SleepingOwlModel();

        $ordersItemsBodyView = new ModelViews\OrdersItemsBody($ordersItemsBodyModel);

        $items = [
            $ordersItemsBodyView->get()
        ];

        return [
            'customer_id' => 0,
            'total'       => 0,
            'items'       => $items,
        ];
    }

}