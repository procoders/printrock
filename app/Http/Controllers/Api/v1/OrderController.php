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

        $validator = Validator::make($params, [
            'customer_id' => 'required|numeric',
            'total'       => 'required|numeric',
            'items'       => 'required'

//
//            'rooms_type'          => 'required|integer|min:1|exists:hotels_rooms_types,id',
//            'rooms_count'         => 'required|integer|min:1',
//            'accommodation'       => 'required|integer|exists:hotels_accommodations,id',
//            'client_first_name'   => 'required',
//            'client_last_name'    => 'required',
//            'client_phone'        => 'required',
//            'client_email'        => 'required|email',
//            'payment_type'        => 'required|alpha_dash|in:NOT_GUARANTEED,GUARANTEED_BY_CARD',
//            'payment_holder_name' => 'required',
//            'payment_card_number' => 'required',
//            'payment_date_month'  => 'required',
//            'payment_date_year'   => 'required|integer',
//            'payment_cvv2'        => 'required',
//            'addons'              => 'regex:"^\d+(,\d+)*$"',
//            'wishes'              => 'regex:"^\d+(,\d+)*$"',
//            'gift'                => 'integer|exists:hotels_gifts,id'
        ]);

        if ($validator->fails()) {
            $response = ['error' => $validator->errors()];
            $statusCode = 500;
        } else {
            $orderModel = new Models\Order();

            $orderModel->getRepository()->saveFromArray($params);

            $orderView = new ModelViews\Order($orderModel);

            $response = $orderView->get();
        }

        return \Response::json($response, $statusCode);
    }

}