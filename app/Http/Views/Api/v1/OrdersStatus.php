<?php

namespace App\Http\Views\Api\v1;

use App\Models as Models;
use App\Http\Views\Api\v1 as ModelViews;

/**
 * Class Language
 * @package App\Http\Views\Api\v1
 *
 * @SWG\Model(id="OrdersStatus")
 */
Class OrdersStatus extends BaseView
{
    /**
     * @SWG\Property(name="id", type="integer", required=true)
     */

    /**
     * @SWG\Property(name="code", type="string", required=true)
     */

    /**
     * @SWG\Property(name="default", type="boolean", required=true)
     */

    /**
     * @SWG\Property(name="name", type="string", required=true)
     */

    public function get()
    {

        $languageId = (int)\Input::get('language_id', $this->_getDefaultLanguageId());

        $description = $this->_model->descriptions()->where('language_id', $languageId)->first();
        $name = (!is_null($description)) ? $description->name : '';

        return [
            'id'           => $this->_model->id,
            'code'         => $this->_model->code,
            'default'      => $this->_model->default,
            'name' => $name
        ];
    }

}