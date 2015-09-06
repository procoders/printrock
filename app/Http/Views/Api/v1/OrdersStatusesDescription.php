<?php

namespace App\Http\Views\Api\v1;

use App\Models as Models;
use App\Http\Views\Api\v1 as ModelViews;

/**
 * Class Language
 * @package App\Http\Views\Api\v1
 *
 * @SWG\Model(id="OrdersStatusesDescription")
 */
Class OrdersStatusesDescription extends BaseView
{
    /**
     * @SWG\Property(name="id", type="integer", required=true)
     */

    /**
     * @SWG\Property(name="name", type="string", required=true)
     */

    /**
     * @SWG\Property(name="language", type="Language", required=true)
     */

    public function get()
    {
        $language = $this->_model->language()->first();

        $languageView = new ModelViews\Language($language);

        return [
            'id'      => $this->_model->id,
            'name'    => $this->_model->name,
            'language' => $languageView->get()
        ];
    }

}