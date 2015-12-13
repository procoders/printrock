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
 *     resourcePath="/formats",
 *     basePath="/api/v1"
 * )
 */
class FormatController extends Controller {

    /**
     * @SWG\Api(
     *   path="/formats/{id}",
     *   @SWG\Operation(
     *     nickname="Get format",
     *     method="GET",
     *     summary="Find format by ID",
     *     notes="Returns format",
     *     type="Format",
     *     authorizations={},
     *     @SWG\Parameter(
     *       name="id",
     *       description="ID of format",
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
                $formatModel = Models\Format::where('id', $id)->first();
                if (! isset($formatModel)) {
                    throw new ModelNotFoundException();
                }
                $formatView = new ModelViews\Format($formatModel);

                $response = $formatView->get();
            }
        } catch (ModelNotFoundException $e) {
            $response = [
                'error' => 'Format doesn\'t exists'
            ];
            $statusCode = 404;
        } finally {
            return \Response::json($response, $statusCode);
        }
    }

    /**
     * @SWG\Api(
     *   path="/formats/",
     *   @SWG\Operation(
     *     nickname="Get all formats",
     *     method="GET",
     *     summary="Find all formats",
     *     notes="Returns all formats",
     *     type="array",
     *     @SWG\Items("Format"),
     *     authorizations={}
     *   )
     * )
     */
    public function all()
    {
        $statusCode = 200;
        $response = [];

        $formatModels = Models\Format::all();
        foreach ($formatModels as $formatModel) {
            $formatView = new ModelViews\Format($formatModel);
            $response[] = $formatView->get();
        }

        return \Response::json($response, $statusCode);
    }

}