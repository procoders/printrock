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
     * @SWG\Property(name="descriptions", type="array", @SWG\Items("OrdersStatusesDescription"), required=true)
     */

    public function get()
    {
        $descriptions = [];

        $languageId = (int)\Input::get('language_id', 0);

        if (!empty($languageId)) {
            $descriptionsModel = $this->_model->descriptions()->where('language_id', $languageId)->get();
        } else {
            $descriptionsModel = $this->_model->descriptions()->get();
        }

        foreach ($descriptionsModel as $ordersStatusesDescriptionModel) {
            $ordersStatusesDescriptionView = new ModelViews\OrdersStatusesDescription($ordersStatusesDescriptionModel);

            $descriptions[] = $ordersStatusesDescriptionView->get();
        }

        return [
            'id'           => $this->_model->id,
            'code'         => $this->_model->code,
            'default'      => $this->_model->default,
            'descriptions' => $descriptions
        ];
    }

}