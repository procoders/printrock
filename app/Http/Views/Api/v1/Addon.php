<?php

namespace App\Http\Views\Api\v1;

use App\Models as Models;
use App\Http\Views\Api\v1 as ModelViews;

/**
 * Class Addon
 * @package App\Http\Views\Api\v1
 *
 * @SWG\Model(id="Addon")
 */
Class Addon extends BaseView
{
    /**
     * @SWG\Property(name="id", type="integer", required=true)
     */

    /**
     * @SWG\Property(name="name", type="string", required=true)
     */

    /**
     * @SWG\Property(name="image", type="string", required=true)
     */

    /**
     * @SWG\Property(name="price_type", type="string", required=true)
     */

    /**
     * @SWG\Property(name="price", type="float", required=true)
     */

    /**
     * @SWG\Property(name="type", type="AddonsType", required=true)
     */

    public function get()
    {
        $addonsType = $this->_model->type()->first();

        $addonsTypeView = new ModelViews\AddonsType($addonsType);

        $languageId = (int)\Input::get('language_id', $this->_getDefaultLanguageId());

        $description = $this->_model->descriptions()->where('language_id', $languageId)->first();
        $name = (!is_null($description)) ? $description->name : '';


        $result = [
            'id'         => $this->_model->id,
            'name'       => $name,
            'image'      => $this->_model->image,
            'price_type' => $this->_model->price_type,
            'price'      => $this->_model->price,
            'type'       => $addonsTypeView->get()
        ];

        return $result;
    }

}