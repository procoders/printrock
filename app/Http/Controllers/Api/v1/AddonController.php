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
 *     resourcePath="/addon",
 *     basePath="/api/v1"
 * )
 */
class AddonController extends Controller {

    /**
     * @SWG\Api(
     *   path="/addon/get/{id}",
     *   @SWG\Operation(
     *     nickname="Get addon",
     *     method="GET",
     *     summary="Find addon by ID",
     *     notes="Returns addon",
     *     type="Addon",
     *     authorizations={},
     *     @SWG\Parameter(
     *       name="id",
     *       description="ID of addon",
     *       required=true,
     *       type="integer",
     *       format="int64",
     *       paramType="path",
     *       allowMultiple=false
     *     ),
     *     @SWG\ResponseMessage(code=404, message="Format not found"),
     *     @SWG\ResponseMessage(code=500, message="Internal server error")
     *   )
     * )
     */
    public function get($id)
    {
        $statusCode = 200;
        $response = [];

        try {
            $validator = Validator::make(['id' => $id], [
                'id' => 'required|numeric'
            ]);

            if ($validator->fails()) {
                $response = ['error' => $validator->errors()];
                $statusCode = 500;
            } else {
                $addonModel = Models\Addon::where('id', $id)->first();
                if (! isset($addonModel)) {
                    throw new ModelNotFoundException();
                }
                $addonView = new ModelViews\Addon($addonModel);
                $addonsTypeView = new ModelViews\AddonsType($addonModel->type()->first());
                $addon = $addonView->get();
                $addon['type'] = $addonsTypeView->get();
                $response = $addon;
            }
        } catch (ModelNotFoundException $e) {
            $response = [
                'error' => 'Addon doesn\'t exists'
            ];
            $statusCode = 404;
        } finally {
            return \Response::json($response, $statusCode);
        }
    }

    /**
     * @SWG\Api(
     *   path="/addon/all",
     *   @SWG\Operation(
     *     nickname="Get all addons",
     *     method="GET",
     *     summary="Find all addons",
     *     notes="Returns all addons",
     *     type="array",
     *     @SWG\Items("Addon"),
     *     authorizations={},
     *     @SWG\Parameter(
     *       name="type_id",
     *       description="ID of addons type",
     *       required=false,
     *       type="integer",
     *       paramType="query",
     *       allowMultiple=false
     *     ),
     *     @SWG\Parameter(
     *       name="price_type",
     *       description="Price Type",
     *       required=false,
     *       type="string",
     *       enum="['price', 'percent']",
     *       paramType="query",
     *       allowMultiple=false
     *     ),
     *     @SWG\ResponseMessage(code=500, message="Internal server error")
     *   )
     * )
     */
    public function all()
    {
        $statusCode = 200;
        $response = [];

        $inputs = \Input::all();

        $validator = Validator::make($inputs, [
            'type_id' => 'numeric',
        ]);

        if ($validator->fails()) {
            $response = ['error' => $validator->errors()];
            $statusCode = 500;
        } else {
            $addonModels = new Models\Addon();
            if (isset($inputs['type_id']) && $inputs['type_id']) {
                $addonModels = $addonModels->where('addons_type_id', $inputs['type_id']);
            }
            if (isset($inputs['price_type']) && $inputs['price_type']) {
                $addonModels = $addonModels->where('price_type', $inputs['price_type']);
            }

            foreach ($addonModels->get() as $addonModel) {
                $addonView = new ModelViews\Addon($addonModel);
                $addonsTypeView = new ModelViews\AddonsType($addonModel->type()->first());
                $addon = $addonView->get();
                $addon['type'] = $addonsTypeView->get();
                $response[] = $addon;
            }
        }

        return \Response::json($response, $statusCode);
    }

}