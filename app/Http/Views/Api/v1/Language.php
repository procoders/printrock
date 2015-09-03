<?php

namespace App\Http\Views\Api\v1;

use App\Models as Models;

/**
 * Class Language
 * @package App\Http\Views\Api\v1
 *
 * @SWG\Model(id="Language")
 */
Class Language extends BaseView
{
    /**
     * @SWG\Property(name="id", type="integer", required=true)
     */

    /**
     * @SWG\Property(name="code", type="string", required=true)
     */

    /**
     * @SWG\Property(name="name", type="string", required=true)
     */

    public function get()
    {
        return [
            'id'   => $this->_model->id,
            'code' => $this->_model->code,
            'name' => $this->_model->name
        ];
    }

}