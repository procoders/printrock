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
 *     resourcePath="/addons_type",
 *     basePath="/api/v1"
 * )
 */
class AddonsTypeController extends Controller {

    /**
     * @SWG\Api(
     *   path="/addons_type/get/{id}",
     *   @SWG\Operation(
     *     nickname="Get addons type",
     *     method="GET",
     *     summary="Find addons type by ID",
     *     notes="Returns addons type",
     *     type="AddonsType",
     *     authorizations={},
     *     @SWG\Parameter(
     *       name="id",
     *       description="ID of addons type",
     *       required=true,
     *       type="integer",
     *       format="int64",
     *       paramType="path",
     *       allowMultiple=false
     *     ),
     *     @SWG\ResponseMessage(code=404, message="Addons type not found"),
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
                $addonsTypeModel = Models\AddonsType::where('id', $id)->first();
                if (! isset($addonsTypeModel)) {
                    throw new ModelNotFoundException();
                }
                $addonsTypeView = new ModelViews\AddonsType($addonsTypeModel);
                $response = $addonsTypeView->get();
            }
        } catch (ModelNotFoundException $e) {
            $response = [
                'error' => 'Addons type doesn\'t exists'
            ];
            $statusCode = 404;
        } finally {
            return \Response::json($response, $statusCode);
        }
    }

    /**
     * @SWG\Api(
     *   path="/addons_type/all",
     *   @SWG\Operation(
     *     nickname="Get all addons type",
     *     method="GET",
     *     summary="Find all addons type",
     *     notes="Returns all addons type",
     *     type="array",
     *     @SWG\Items("AddonsType"),
     *     authorizations={}
     *   )
     * )
     */
    public function all()
    {
        $statusCode = 200;
        $response = [];

        $addonstypeModels = Models\AddonsType::all();
        foreach ($addonstypeModels as $addonstypeModel) {
            $addonsTypeView = new ModelViews\AddonsType($addonstypeModel);
            $response[] = $addonsTypeView->get();
        }

        return \Response::json($response, $statusCode);
    }

}