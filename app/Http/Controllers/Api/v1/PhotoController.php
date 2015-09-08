<?php namespace App\Http\Controllers\Api\v1;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\ModelNotFoundException as ModelNotFoundException;
use App\Models as Models;
use App\Http\Views\Api\v1 as ModelViews;
use Validator;

/**
 * @SWG\Resource(
 *     apiVersion="0.1",
 *     swaggerVersion="1.2",
 *     resourcePath="/photo",
 *     basePath="/api/v1"
 * )
 */
class PhotoController extends Controller
{
    /**
     * @SWG\Api(
     *   path="/photo/add",
     *   @SWG\Operation(
     *     nickname="Add new photo",
     *     method="POST",
     *     summary="Add new photo",
     *     notes="Returns photo",
     *     type="Photo",
     *     authorizations={},
     *     @SWG\Parameter(
     *       name="customer_id",
     *       description="Customer ID",
     *       required=true,
     *       type="integer",
     *       format="int64",
     *       paramType="form",
     *       allowMultiple=false
     *     ),
     *     @SWG\Parameter(
     *       name="image",
     *       description="Image",
     *       type="file",
     *       required=true,
     *       allowMultiple=true,
     *       paramType="body"
     *     ),
     *     @SWG\ResponseMessage(code=500, message="Internal server error")
     *   )
     * )
     */
    public function add()
    {
        $statusCode = 200;

        $inputs = \Input::all();

        $validator = Validator::make($inputs, [
            'customer_id' => 'required|numeric|exists:customers,id',
            'image' => 'required|image'
        ]);

        if ($validator->fails()) {
            $response = ['error' => $validator->errors()];
            $statusCode = 500;
        } else {
            $params = [
                'customer_id' => $inputs['customer_id'],
                'image' => $inputs['image']
            ];

            $photo = new Models\Photo();

            $photo->getRepository()->saveFromArray($params);

            $photoView = new ModelViews\Photo($photo);

            $response = $photoView->get();
        }

        return \Response::json($response, $statusCode);
    }
}