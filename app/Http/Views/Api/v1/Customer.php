<?php

namespace App\Http\Views\Api\v1;

use App\Models as Models;
use App\Http\Views\Api\v1 as ModelViews;

/**
 * Class Customer
 * @package App\Http\Views\Api\v1
 *
 * @SWG\Model(id="Customer")
 */
Class Customer extends BaseView
{
    /**
     * @SWG\Property(name="id", type="integer", required=true)
     */

    /**
     * @SWG\Property(name="name", type="string", required=true)
     */

    /**
     * @SWG\Property(name="second_name", type="string", required=true)
     */

    /**
     * @SWG\Property(name="last_name", type="string", required=true)
     */

    /**
     * @SWG\Property(name="email", type="string", required=true)
     */

    /**
     * @SWG\Property(name="phone", type="string", required=true)
     */

    /**
     * @SWG\Property(name="login", type="string", required=true)
     */

    /**
     * @SWG\Property(name="addresses", type="array", @SWG\Items("CustomersAddress"), required=true)
     */

    public function get()
    {
        $result = [
            'id'          => $this->_model->id,
            'name'        => $this->_model->name,
            'second_name' => $this->_model->second_name,
            'last_name'   => $this->_model->last_name,
            'email'       => $this->_model->email,
            'phone'       => $this->_model->phone,
            'login'       => $this->_model->login
        ];

        $addresses = [];
        foreach ($this->_model->addresses()->get() as $customersAddressModel) {
            $customersAddressView = new ModelViews\CustomersAddress($customersAddressModel);
            $addresses[] = $customersAddressView->get();
        }

        $result['addresses'] = $addresses;

        return $result;
    }

}