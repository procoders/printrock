<?php

namespace App\Http\Views\Api\v1;

use App\Models as Models;

/**
 * Class Format
 * @package App\Http\Views\Api\v1
 *
 * @SWG\Model(id="Format")
 */
Class Format extends BaseView
{
    /**
     * @SWG\Property(name="id", type="integer", required=true)
     */

    /**
     * @SWG\Property(name="width", type="integer", required=true)
     */

    /**
     * @SWG\Property(name="height", type="integer", required=true)
     */

    /**
     * @SWG\Property(name="price", type="integer", required=true)
     */

    public function get()
    {
        return [
            'id'     => $this->_model->id,
            'width'  => $this->_model->width,
            'height' => $this->_model->height,
            'price'  => $this->_model->price
        ];
    }

}