<?php

namespace App\Http\Views\Api\v1;

use App\Models as Models;
use App\Http\Views\Api\v1 as ModelViews;

/**
 * Class OrdersCalculateBody
 * @package App\Http\Views\Api\v1
 *
 * @SWG\Model(id="OrdersCalculateBody")
 */
Class OrdersCalculateBody extends BaseView
{

    /**
     * @SWG\Property(name="items", type="array", @SWG\Items("OrdersItemsCalculateBody"), required=true)
     */

    public function get()
    {
        $ordersItemsBodyModel = new SleepingOwlModel();

        $ordersItemsBodyView = new ModelViews\OrdersItemsCalculateBody($ordersItemsBodyModel);

        $items = [
            $ordersItemsBodyView->get()
        ];

        return [
            'items'       => $items
        ];
    }

}