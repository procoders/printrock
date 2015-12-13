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
 *     resourcePath="/orders_status",
 *     basePath="/api/v1"
 * )
 */
class OrdersStatusController extends Controller {

    /**
     * @SWG\Api(
     *   path="/orders_status/{id}",
     *   @SWG\Operation(
     *     nickname="Get orders status",
     *     method="GET",
     *     summary="Find orders status by ID",
     *     notes="Returns oreders status",
     *     type="OrdersStatus",
     *     authorizations={},
     *     @SWG\Parameter(
     *       name="id",
     *       description="ID of orders status",
     *       required=true,
     *       type="integer",
     *       format="int64",
     *       paramType="path",
     *       allowMultiple=false
     *     ),
     *     @SWG\Parameter(
     *       name="language_id",
     *       description="ID of language",
     *       type="integer",
     *       format="int64",
     *       paramType="query",
     *       allowMultiple=false
     *     ),
     *     @SWG\ResponseMessage(code=404, message="Orders status not found"),
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
                $ordersStatusModel = Models\OrdersStatus::where('id', $id)->first();
                if (! isset($ordersStatusModel)) {
                    throw new ModelNotFoundException();
                }

                $ordersStatusView = new ModelViews\OrdersStatus($ordersStatusModel);

                $response = $ordersStatusView->get();
            }
        } catch (ModelNotFoundException $e) {
            $response = [
                'error' => 'Orders status doesn\'t exists'
            ];
            $statusCode = 404;
        } finally {
            return \Response::json($response, $statusCode);
        }
    }

    /**
     * @SWG\Api(
     *   path="/orders_status/",
     *   @SWG\Operation(
     *     nickname="Get all orders status",
     *     method="GET",
     *     summary="Find all orders status",
     *     notes="Returns all orders status",
     *     type="array",
     *     @SWG\Items("OrdersStatus"),
     *     authorizations={},
     *     @SWG\Parameter(
     *       name="language_id",
     *       description="ID of language",
     *       type="integer",
     *       format="int64",
     *       paramType="query",
     *       allowMultiple=false
     *     ),
     *  ),
     * )
     */
    public function all()
    {
        $statusCode = 200;
        $response = [];

        $ordersStatusModels = Models\OrdersStatus::all();
        foreach ($ordersStatusModels as $ordersStatusModel) {
            $ordersStatusView = new ModelViews\OrdersStatus($ordersStatusModel);
            $response[] = $ordersStatusView->get();
        }

        return \Response::json($response, $statusCode);
    }

}