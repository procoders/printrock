<?php

namespace App\Http\Views\Api\v1;

use App\Models as Models;

/**
 * Class Photo
 * @package App\Http\Views\Api\v1
 *
 * @SWG\Model(id="Photo")
 */
Class Photo extends BaseView
{
    /**
     * @SWG\Property(name="id", type="integer", required=true)
     */

    /**
     * @SWG\Property(name="image", type="string", required=true)
     */

    public function get()
    {
        return [
            'id'          => $this->_model->id,
            'image'       => $this->_model->image
        ];
    }

}