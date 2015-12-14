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
 *     resourcePath="/customers",
 *     basePath="/api/v1"
 * )
 */
class CustomerController extends Controller {

    /**
     * @SWG\Api(
     *   path="/customers/{id}",
     *   @SWG\Operation(
     *     nickname="Get customer",
     *     method="GET",
     *     summary="Find customer by ID",
     *     notes="Returns customer",
     *     type="Customer",
     *     authorizations={},
     *     @SWG\Parameter(
     *       name="id",
     *       description="ID of customer",
     *       required=true,
     *       type="integer",
     *       format="int64",
     *       paramType="path",
     *       allowMultiple=false
     *     ),
     *     @SWG\ResponseMessage(code=404, message="Customer not found"),
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
                $customerModel = Models\Customer::where('id', $id)->first();
                if (! isset($customerModel)) {
                    throw new ModelNotFoundException();
                }
                $customerView = new ModelViews\Customer($customerModel);

                $response = $customerView->get();
            }
        } catch (ModelNotFoundException $e) {
            $response = [
                'error' => 'Customer doesn\'t exists'
            ];
            $statusCode = 404;
        } finally {
            return \Response::json($response, $statusCode);
        }
    }

    /**
     * @SWG\Api(
     *   path="/customers/",
     *   @SWG\Operation(
     *     nickname="Add new cusromer",
     *     method="POST",
     *     summary="Add new customer",
     *     notes="Returns customer",
     *     type="Customer",
     *     authorizations={},
     *     @SWG\Parameter(
     *       name="name",
     *       description="Name",
     *       required=true,
     *       type="string",
     *       paramType="form",
     *       allowMultiple=false
     *     ),
     *     @SWG\Parameter(
     *       name="second_name",
     *       description="Second Name",
     *       required=true,
     *       type="string",
     *       paramType="form",
     *       allowMultiple=false
     *     ),
     *     @SWG\Parameter(
     *       name="last_name",
     *       description="Last Name",
     *       required=true,
     *       type="string",
     *       paramType="form",
     *       allowMultiple=false
     *     ),
     *     @SWG\Parameter(
     *       name="email",
     *       description="Email",
     *       required=true,
     *       type="string",
     *       paramType="form",
     *       allowMultiple=false
     *     ),
     *     @SWG\Parameter(
     *       name="phone",
     *       description="Phone",
     *       required=true,
     *       type="string",
     *       paramType="form",
     *       allowMultiple=false
     *     ),
     *     @SWG\Parameter(
     *       name="login",
     *       description="Login",
     *       required=true,
     *       type="string",
     *       paramType="form",
     *       allowMultiple=false
     *     ),
     *     @SWG\Parameter(
     *       name="password",
     *       description="Password",
     *       required=true,
     *       type="string",
     *       paramType="form",
     *       allowMultiple=false
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
            'name'        => 'required|max:100',
            'second_name' => 'required|max:100',
            'last_name'   => 'required|max:100',
            'email'       => 'required|email|unique:customers,email',
            'phone'       => 'required|max:100',
            'login'       => 'required|unique:customers,login',
            'password'    => 'required'
        ]);

        if ($validator->fails()) {
            $response = ['error' => $validator->errors()];
            $statusCode = 500;
        } else {
            $params = [
                'name'        => $inputs['name'],
                'second_name' => $inputs['second_name'],
                'last_name'   => $inputs['last_name'],
                'email'       => $inputs['email'],
                'phone'       => $inputs['phone'],
                'login'       => $inputs['login'],
                'password'    => \Hash::make($inputs['password'])
            ];

            $customer = new Models\Customer();

            $customer->getRepository()->saveFromArray($params);

            $customerView = new ModelViews\Customer($customer);

            $response = $customerView->get();
        }

        return \Response::json($response, $statusCode);
    }

    /**
     * @SWG\Api(
     *   path="/customers/login",
     *   @SWG\Operation(
     *     nickname="Login",
     *     method="POST",
     *     summary="Login cusomer",
     *     type="Customer",
     *     authorizations={},
     *     @SWG\Parameter(
     *       name="login",
     *       description="Login",
     *       required=true,
     *       type="string",
     *       paramType="form",
     *       allowMultiple=false
     *     ),
     *     @SWG\Parameter(
     *       name="password",
     *       description="Password",
     *       required=true,
     *       type="string",
     *       paramType="form",
     *       allowMultiple=false
     *     ),
     *     @SWG\ResponseMessage(code=404, message="Customer not found"),
     *     @SWG\ResponseMessage(code=500, message="Internal server error")
     *   )
     * )
     */
    public function login()
    {
        $statusCode = 200;

        $inputs = \Input::all();

        try {
            $customerModel = Models\Customer::where([
                'login' => $inputs['login'],
                'password' => $inputs['password']
            ])->first();
            if (! isset($customerModel)) {
                throw new ModelNotFoundException();
            }
            $customerView = new ModelViews\Customer($customerModel);

            $response = $customerView->get();
        } catch (ModelNotFoundException $e) {
            $response = [
                'error' => 'Customer doesn\'t exists'
            ];
            $statusCode = 404;
        } finally {
            return \Response::json($response, $statusCode);
        }
    }

    /**
     * @SWG\Api(
     *   path="/customers/{customerId}/orders",
     *   @SWG\Operation(
     *     nickname="Get all orders",
     *     method="GET",
     *     summary="Will return all order of selected customer",
     *     notes="",
     *     type="Order",
     *     authorizations={},
     *     @SWG\Parameter(
     *       name="customerId",
     *       description="Customer Id",
     *       required=true,
     *       type="integer",
     *       format="int64",
     *       paramType="path",
     *       allowMultiple=false
     *     ),
     *     @SWG\ResponseMessage(code=404, message="Orders not found"),
     *     @SWG\ResponseMessage(code=500, message="Internal server error")
     *   )
     * )
     */
    public function getOrders($customerId)
    {
        $statusCode = 200;
        $response = [];
        $ordersModel = Models\Order::where('customer_id', $customerId);

        if ($ordersModel->count() == 0) {
            $statusCode = 404;
        } else {
            foreach ($ordersModel as $mode) {
                $response[] = (new ModelViews\Order($orderModel))->get();
            }
        }

        return \Response::json($response, $statusCode);
    }

    /**
     * @SWG\Api(
     *   path="/customers/{customerId}/orders/{id}",
     *   @SWG\Operation(
     *     nickname="Get order",
     *     method="GET",
     *     summary="Find order by ID",
     *     notes="Returns order status",
     *     type="Order",
     *     authorizations={},
     *     @SWG\Parameter(
     *       name="customerId",
     *       description="Customer Id",
     *       required=true,
     *       type="integer",
     *       format="int64",
     *       paramType="path",
     *       allowMultiple=false
     *     ),
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
    public function getOrderById($customerId, $id)
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
                $orderModel = Models\Order::where('id', $id)
                    ->where('customer_id', $customerId)
                    ->first();
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
     *   path="/customers/{customerId}/orders/{id}/status",
     *   @SWG\Operation(
     *     nickname="Get order",
     *     method="GET",
     *     summary="Find order and return it status",
     *     notes="Returns order status",
     *     type="Order",
     *     authorizations={},
     *     @SWG\Parameter(
     *       name="customerId",
     *       description="Customer Id",
     *       required=true,
     *       type="integer",
     *       format="int64",
     *       paramType="path",
     *       allowMultiple=false
     *     ),
     *     @SWG\Parameter(
     *       name="id",
     *       description="ID of order",
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
     *     @SWG\ResponseMessage(code=404, message="Order not found"),
     *     @SWG\ResponseMessage(code=500, message="Internal server error")
     *   )
     * )
     */
    public function getOrderStatusByOrderId($customerId, $id)
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
                $orderModel = Models\Order::where('id', $id)
                    ->where('customer_id', $customerId)
                    ->first();
                if (! isset($orderModel)) {
                    throw new ModelNotFoundException();
                }

                $ordersStatusView = new ModelViews\OrdersStatus($orderModel->status());

                $response = $ordersStatusView->get();
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
     *   path="/customers/{customerId}/orders",
     *   @SWG\Operation(
     *     nickname="Add new order",
     *     method="POST",
     *     summary="Add new order",
     *     notes="Returns order",
     *     type="Order",
     *     authorizations={},
     *     @SWG\Parameter(
     *       name="customerId",
     *       description="Customer Id",
     *       required=true,
     *       type="integer",
     *       format="int64",
     *       paramType="path",
     *       allowMultiple=false
     *     ),
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
    public function addOrder($customerId)
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
                    } else {
                        foreach ($itemsAddonsValidator[$itemKey] as $addonKey => $validator) {
                            if ($validator->fails()) {
                                $errors['items'][$itemKey + 1]['addons'][$addonKey + 1] = $validator->errors();
                            }
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

    /**
     * @SWG\Api(
     *   path="/customers/{customerId}/address/{id}",
     *   @SWG\Operation(
     *     nickname="Get customers address",
     *     method="GET",
     *     summary="Find customers address by ID",
     *     notes="Returns customers address",
     *     type="CustomersAddress",
     *     authorizations={},
     *     @SWG\Parameter(
     *       name="customerId",
     *       description="Customer Id",
     *       required=true,
     *       type="integer",
     *       format="int64",
     *       paramType="path",
     *       allowMultiple=false
     *     ),
     *     @SWG\Parameter(
     *       name="id",
     *       description="ID of customers address",
     *       required=true,
     *       type="integer",
     *       format="int64",
     *       paramType="path",
     *       allowMultiple=false
     *     ),
     *     @SWG\ResponseMessage(code=404, message="Customers address not found"),
     *     @SWG\ResponseMessage(code=500, message="Internal server error")
     *   )
     * )
     */
    public function getAddressById($customerId, $id)
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
                $customersAddressModel = Models\CustomersAddress::where('id', $id)
                    ->where('customer_id', $customerId)
                    ->first();
                if (!isset($customersAddressModel)) {
                    throw new ModelNotFoundException();
                }
                $customersAddressView = new ModelViews\CustomersAddress($customersAddressModel);

                $response = $customersAddressView->get();
            }
        } catch (ModelNotFoundException $e) {
            $response = [
                'error' => 'Customers address doesn\'t exists'
            ];
            $statusCode = 404;
        } finally {
            return \Response::json($response, $statusCode);
        }
    }

    /**
     * @SWG\Api(
     *   path="/customers/{customerId}/address",
     *   @SWG\Operation(
     *     nickname="Get customers all addresses",
     *     method="GET",
     *     summary="Get customers all addresses",
     *     notes="Returns customers address collection",
     *     type="CustomersAddress",
     *     authorizations={},
     *     @SWG\Parameter(
     *       name="customerId",
     *       description="Customer Id",
     *       required=true,
     *       type="integer",
     *       format="int64",
     *       paramType="path",
     *       allowMultiple=false
     *     ),
     *     @SWG\ResponseMessage(code=404, message="Customers address not found"),
     *     @SWG\ResponseMessage(code=500, message="Internal server error")
     *   )
     * )
     */
    public function getAddressCustomerId($customerId)
    {
        $statusCode = 200;
        $response = [];

        try {
            $customersAddressModel = Models\CustomersAddress::where('customer_id', $customerId);

            foreach ($customersAddressModel->get() as $address) {
                $model = new ModelViews\CustomersAddress($address);
                $response[] = $model->get();
            }

        } catch (ModelNotFoundException $e) {
            $response = [
                'error' => 'Customers address doesn\'t exists'
            ];
            $statusCode = 404;
        } finally {
            return \Response::json($response, $statusCode);
        }
    }

    /**
     * @SWG\Api(
     *   path="/customers/{customerId}/address/",
     *   @SWG\Operation(
     *     nickname="Add new customers address",
     *     method="POST",
     *     summary="Add new customers address",
     *     notes="Returns customers address",
     *     type="CustomersAddress",
     *     authorizations={},
     *     @SWG\Parameter(
     *       name="customerId",
     *       description="Customer Id",
     *       required=true,
     *       type="integer",
     *       format="int64",
     *       paramType="path",
     *       allowMultiple=false
     *     ),
     *     @SWG\Parameter(
     *       name="country",
     *       description="Country",
     *       required=true,
     *       type="string",
     *       paramType="form",
     *       allowMultiple=false
     *     ),
     *     @SWG\Parameter(
     *       name="city",
     *       description="City",
     *       required=true,
     *       type="string",
     *       paramType="form",
     *       allowMultiple=false
     *     ),
     *     @SWG\Parameter(
     *       name="phone",
     *       description="Phone",
     *       required=true,
     *       type="string",
     *       paramType="form",
     *       allowMultiple=false
     *     ),
     *     @SWG\Parameter(
     *       name="zip_code",
     *       description="Zip Code",
     *       required=true,
     *       type="string",
     *       paramType="form",
     *       allowMultiple=false
     *     ),
     *     @SWG\Parameter(
     *       name="name",
     *       description="Name",
     *       required=true,
     *       type="string",
     *       paramType="form",
     *       allowMultiple=false
     *     ),
     *     @SWG\Parameter(
     *       name="street",
     *       description="Street",
     *       required=true,
     *       type="string",
     *       paramType="form",
     *       allowMultiple=false
     *     ),
     *     @SWG\ResponseMessage(code=500, message="Internal server error")
     *   )
     * )
     */
    public function addAddress($customerId)
    {
        $statusCode = 200;

        $inputs = \Input::all();
        $inputs['customer_id'] = $customerId;

        $validator = Validator::make($inputs, [
            'customer_id' => 'required|numeric|exists:customers,id',
            'country'     => 'required|alpha|max:100',
            'city'        => 'required|alpha|max:100',
            'phone'       => 'required|max:100',
            'zip_code'    => 'required|regex:"^\d{5}(?:[-\s]\d{4})?$"',
            'name'        => 'required',
            'street'      => 'required'
        ]);

        if ($validator->fails()) {
            $response = ['error' => $validator->errors()];
            $statusCode = 500;
        } else {
            $params = [
                'customer_id' => $customerId,
                'country'     => $inputs['country'],
                'city'        => $inputs['city'],
                'phone'       => $inputs['phone'],
                'zip_code'    => $inputs['zip_code'],
                'name'        => $inputs['name'],
                'street'      => $inputs['street']
            ];

            $customersAddress = new Models\CustomersAddress();

            $customersAddress->getRepository()->saveFromArray($params);

            $customersAddressView = new ModelViews\CustomersAddress($customersAddress);

            $response = $customersAddressView->get();
        }

        return \Response::json($response, $statusCode);
    }

}