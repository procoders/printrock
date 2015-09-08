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
 *     resourcePath="/order",
 *     basePath="/api/v1"
 * )
 */
class OrderController extends Controller {

    /**
     * @SWG\Api(
     *   path="/order/get/{id}",
     *   @SWG\Operation(
     *     nickname="Get order",
     *     method="GET",
     *     summary="Find order by ID",
     *     notes="Returns order status",
     *     type="Order",
     *     authorizations={},
     *     @SWG\Parameter(
     *       name="id",
     *       description="ID of order",
     *       required=true,
     *       type="integer",
     *       format="int64",
     *       paramType="path",
     *       allowMultiple=false
     *     ),
     *     @SWG\ResponseMessage(code=404, message="Order not found"),
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
                $orderModel = Models\Order::where('id', $id)->first();
                if (! isset($orderModel)) {
                    throw new ModelNotFoundException();
                }
                $orderView = new ModelViews\Order($orderModel);

                $response = $orderView->get();
            }
        } catch (ModelNotFoundException $e) {
            $response = [
                'error' => 'Order doesn\'t exists'
            ];
            $statusCode = 404;
        } finally {
            return \Response::json($response, $statusCode);
        }
    }

    /**
     * @SWG\Api(
     *   path="/order/add",
     *   @SWG\Operation(
     *     nickname="Add new order",
     *     method="POST",
     *     summary="Add new order",
     *     notes="Returns order",
     *     type="Order",
     *     authorizations={},
     *     @SWG\Parameter(
     *       name="Body",
     *       description="Body",
     *       required=true,
     *       type="OrdersBody",
     *       paramType="body",
     *       allowMultiple=false
     *     ),
     *     @SWG\ResponseMessage(code=500, message="Internal server error")
     *   )
     * )
     */
    public function add()
    {
        $statusCode = 200;

        $params = \Input::all();

        if ($params) {
            $errors = [];
            $mainValidator = Validator::make($params, [
                'customer_id' => 'required|numeric|exists:customers,id',
                'total' => 'required|numeric|min:1',
                'items' => 'required|array'
            ]);

            if ($mainValidator->fails()) {
                $response = ['error' => [
                    'main' => $mainValidator->errors()
                ]];
                $statusCode = 500;
            } else {
                $itemsValidator = [];
                $itemsAddonsValidator = [];

                foreach ($params['items'] as $itemKey => $item) {
                    $itemsValidator[$itemKey] = Validator::make($item, [
                        'photo_id' => 'required|numeric|exists:photos,id',
                        'qty' => 'required|numeric|min:1',
                        'price_per_item' => 'required|numeric',
                        'format_id' => 'required|numeric|exists:formats,id',
                        'addons' => 'required|array'
                    ]);

                    foreach ($item['addons'] as $addon) {
                        $itemsAddonsValidator[$itemKey][] = Validator::make($addon, [
                            'id' => 'required|numeric|exists:addons,id',
                            'qty' => 'required|numeric|min:1'
                        ]);
                    }
                }

                foreach ($itemsValidator as $itemKey => $validator) {
                    if ($validator->fails()) {
                        $errors['items'][$itemKey + 1] = $validator->errors();
                    }
                    foreach ($itemsAddonsValidator[$itemKey] as $addonKey => $validator) {
                        if ($validator->fails()) {
                            $errors['items'][$itemKey + 1]['addons'][$addonKey + 1] = $validator->errors();
                        }
                    }
                }

                if ($errors) {
                    $response = ['error' => $errors];
                    $statusCode = 500;
                } else {
                    $orderModel = new Models\Order();

                    $orderModel->getRepository()->saveFromArray($params);

                    $orderView = new ModelViews\Order($orderModel);

                    $response = $orderView->get();
                }
            }
        } else {
            $response = ['error' => 'Empty or invalid body'];
            $statusCode = 500;
        }

        return \Response::json($response, $statusCode);
    }

}