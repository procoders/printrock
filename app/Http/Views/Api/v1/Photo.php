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

    /**
     * @SWG\Property(name="resolution", type="string", required=true)
     */

    /**
     * @SWG\Property(name="created", type="string", required=true)
     */

    public function get()
    {

        $resolution = '';

        if (file_exists(public_path() . DIRECTORY_SEPARATOR . $this->_model->image)) {
            list($width, $height) = getimagesize(public_path() . DIRECTORY_SEPARATOR . $this->_model->image);

            if (!empty($width) && !empty($height)) {
                $resolution = $width . 'x' . $height;
            }
        }

        return [
            'id'          => $this->_model->id,
            'image'       => $this->_model->image,
            'resolution'  => $resolution,
            'created'     => strtotime($this->_model->created_at)
        ];
    }

}