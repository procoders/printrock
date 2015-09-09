<?php

namespace App\Http\Controllers;

use SleepingOwl\Admin\Controllers\AdminController;
use App\Models;
use Illuminate\Database\Eloquent\ModelNotFoundException as ModelNotFoundException;

class AjaxController extends AdminController
{
    /**
     * Deletes photos
     *
     * @param integer $photoId
     * @return array
     */
    public function deletePhoto($photoId)
    {
        try {
            $photoModel = Models\Photo::where('id', $photoId)->first();

            $photoModel->delete();

            $result = ['error' => false];
        } catch (ModelNotFoundException $exception) {
            $result = ['error' => true, 'message' => $exception->getMessage()];
        }

        return json_encode($result);
    }

}