<?php

namespace App\Http\Views\Api\v1;

use App\Models as Models;
use App\Http\Views\Api\v1 as ModelViews;

/**
 * Class OrdersItemsAddonsCalculateBody
 * @package App\Http\Views\Api\v1
 *
 * @SWG\Model(id="OrdersItemsAddonsCalculateBody")
 */
Class OrdersItemsAddonsCalculateBody extends BaseView
{
    /**
     * @SWG\Property(name="id", type="integer", required=true)
     */

    /**
     * @SWG\Property(name="qty", type="integer", required=true)
     */

    public function get()
    {
        return [
            'id'  => 0,
            'qty' => 0
        ];
    }

}