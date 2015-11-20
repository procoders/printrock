<?php

namespace App\Http\Views\Api\v1;

use App\Models as Models;

/**
 * Class CustomersAddress
 * @package App\Http\Views\Api\v1
 *
 * @SWG\Model(id="CustomersAddress")
 */
Class CustomersAddress extends BaseView
{
    /**
     * @SWG\Property(name="id", type="integer", required=true)
     */

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
            'id'       => $this->_model->id,
            'country'  => $this->_model->country,
            'city'     => $this->_model->city,
            'phone'    => $this->_model->phone,
            'zip_code' => $this->_model->zip_code,
            'name'     => $this->_model->name,
            'street'   => $this->_model->street,
        ];
    }

}