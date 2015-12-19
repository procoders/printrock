<?php

namespace App\Http\Views\Api\v1;

use App\Models as Models;
use App\Http\Views\Api\v1 as ModelViews;

/**
 * Class Order
 * @package App\Http\Views\Api\v1
 *
 * @SWG\Model(id="Order")
 */
Class Order extends BaseView
{
    /**
     * @SWG\Property(name="id", type="integer", required=true)
     */

    /**
     * @SWG\Property(name="orders_status", type="OrdersStatus", required=true)
     */

    /**
     * @SWG\Property(name="items", type="array", @SWG\Items("OrdersItem"), required=true)
     */

    /**
     * @SWG\Property(name="total", type="integer", required=true)
     */

    /**
     * @SWG\Property(name="comment", type="string", required=false)
     */
    
    /**
     * @SWG\Property(name="delivery", type="OrdersDelivery", required=true)
     */

    public function get()
    {
        $ordersStatusModel = $this->_model->status()->first();

        $ordersStatusView = new ModelViews\OrdersStatus($ordersStatusModel);

        $items = [];
        foreach ($this->_model->items()->get() as $ordersItemModel) {
            $ordersItemView = new ModelViews\OrdersItem($ordersItemModel);
            $items[] = $ordersItemView->get();
        }

        $ordersDeliveryModel = $this->_model->delivery()->first();

        return [
            'id'            => $this->_model->id,
            'orders_status' => $ordersStatusView->get(),
            'delivery'      => (new ModelViews\OrdersDelivery($ordersDeliveryModel))->get(),
            'items'         => $items,
            'total'         => $this->_model->total,
            'comment'       => $this->_model->comment
        ];
    }

}