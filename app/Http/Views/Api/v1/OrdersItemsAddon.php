<?php

namespace App\Http\Views\Api\v1;

use App\Models as Models;
use App\Http\Views\Api\v1 as ModelViews;

/**
 * Class OrdersItemsAddon
 * @package App\Http\Views\Api\v1
 *
 * @SWG\Model(id="OrdersItemsAddon")
 */
Class OrdersItemsAddon extends BaseView
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
     * @SWG\Property(name="qty", type="integer", required=true)
     */

    public function get()
    {
        $addonModel = Models\Addon::find($this->_model->addon_id);
        $addonModel = (is_null($addonModel)) ? new Models\Addon() : $addonModel->first();

        $languageId = (int)\Input::get('language_id', $this->_getDefaultLanguageId());

        $description = $addonModel->descriptions()->where('language_id', $languageId)->first();
        $name = (!is_null($description)) ? $description->name : '';


        return [
            'id'    => $this->_model->addon_id,
            'name'  => $name,
            'image' => $addonModel->image,
            'price' => $this->_model->addon_price,
            'qty'   => $this->_model->qty
        ];
    }

}