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
 *     resourcePath="/languages",
 *     basePath="/api/v1"
 * )
 */
class LanguageController extends Controller {

    /**
     * @SWG\Api(
     *   path="/languages/{id}",
     *   @SWG\Operation(
     *     nickname="Get languge",
     *     method="GET",
     *     summary="Find language by ID",
     *     notes="Returns language",
     *     type="Language",
     *     authorizations={},
     *     @SWG\Parameter(
     *       name="id",
     *       description="ID of language",
     *       required=true,
     *       type="integer",
     *       format="int64",
     *       paramType="path",
     *       allowMultiple=false
     *     ),
     *     @SWG\ResponseMessage(code=404, message="language not found"),
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
                $languageModel = Models\Language::where('id', $id)->first();
                if (! isset($languageModel)) {
                    throw new ModelNotFoundException();
                }
                $languageView = new ModelViews\Language($languageModel);

                $response = $languageView->get();
            }
        } catch (ModelNotFoundException $e) {
            $response = [
                'error' => 'Language doesn\'t exists'
            ];
            $statusCode = 404;
        } finally {
            return \Response::json($response, $statusCode);
        }
    }

    /**
     * @SWG\Api(
     *   path="/languages/",
     *   @SWG\Operation(
     *     nickname="Get all languages",
     *     method="GET",
     *     summary="Find all languages",
     *     notes="Returns all languages",
     *     type="array",
     *     @SWG\Items("Language"),
     *     authorizations={}
     *   )
     * )
     */
    public function all()
    {
        $statusCode = 200;
        $response = [];

        $languageModels = Models\Language::all();
        foreach ($languageModels as $languageModel) {
            $languageView = new ModelViews\Language($languageModel);
            $response[] = $languageView->get();
        }

        return \Response::json($response, $statusCode);
    }

}