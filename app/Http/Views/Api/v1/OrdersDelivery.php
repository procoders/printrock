<?php

namespace App\Http\Views\Api\v1;

use App\Models as Models;
use App\Http\Views\Api\v1 as ModelViews;

/**
 * Class OrdersDelivery
 * @package App\Http\Views\Api\v1
 *
 * @SWG\Model(id="OrdersDelivery")
 */
Class OrdersDelivery extends BaseView
{
    /**
     * @SWG\Property(name="country", type="string", required=true)
     */

    /**
     * @SWG\Property(name="city", type="string", required=true)
     */

    /**
     * @SWG\Property(name="phone", type="string", required=true)
     */

    /**
     * @SWG\Property(name="zip_code", type="string", required=true)
     */

    /**
     * @SWG\Property(name="name", type="string", required=true)
     */

    /**
     * @SWG\Property(name="street", type="string", required=true)
     */

    public function get()
    {
        return [
            'country'  => $this->_model->country,
            'city'     => $this->_model->city,
            'phone'    => $this->_model->phone,
            'zip_code' => $this->_model->zip_code,
            'name'     => $this->_model->name,
            'street'   => $this->_model->street,
        ];
    }

}