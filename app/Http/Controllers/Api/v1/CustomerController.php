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
     *   path="/customers/{id}",
     *   @SWG\Operation(
     *     nickname="Update customer data",
     *     method="PATCH",
     *     summary="Find customer by ID and update it",
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
     *     @SWG\Parameter(
     *       name="name",
     *       description="Name",
     *       required=false,
     *       type="string",
     *       paramType="form",
     *       allowMultiple=false
     *     ),
     *     @SWG\Parameter(
     *       name="second_name",
     *       description="Second Name",
     *       required=false,
     *       type="string",
     *       paramType="form",
     *       allowMultiple=false
     *     ),
     *     @SWG\Parameter(
     *       name="last_name",
     *       description="Last Name",
     *       required=false,
     *       type="string",
     *       paramType="form",
     *       allowMultiple=false
     *     ),
     *     @SWG\Parameter(
     *       name="email",
     *       description="Email",
     *       required=false,
     *       type="string",
     *       paramType="form",
     *       allowMultiple=false
     *     ),
     *     @SWG\Parameter(
     *       name="phone",
     *       description="Phone",
     *       required=false,
     *       type="string",
     *       paramType="form",
     *       allowMultiple=false
     *     ),
     *     @SWG\ResponseMessage(code=404, message="Customer not found"),
     *     @SWG\ResponseMessage(code=500, message="Internal server error")
     *   )
     * )
     */
    public function update($id)
    {
        $statusCode = 200;
        $response = [];
        $inputs = \Input::all();
        $inputs['id'] = $id;

        try {
            $validationRules = [
                'id' => 'required|numeric'
            ];

            if (isset($inputs['email'])) {
                $validationRules['email'] = 'required|email|unique:customers,email';
            }

            $validator = Validator::make($inputs, $validationRules);
            if ($validator->fails()) {
                $response = ['error' => $validator->errors()];
                $statusCode = 500;
            } else {
                $customerModel = Models\Customer::where('id', $id)->first();

                if (! isset($customerModel)) {
                    throw new ModelNotFoundException();
                }

                foreach ($inputs as $key => $val) {
                    switch ($key) {
                        case 'name':
                        case 'second_name':
                        case 'last_name':
                        case 'email':
                        case 'phone':
                            $customerModel->$key = $val;
                            break;
                    }
                }

                $customerModel->save();
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
     *       required=false,
     *       type="string",
     *       paramType="form",
     *       allowMultiple=false
     *     ),
     *     @SWG\Parameter(
     *       name="second_name",
     *       description="Second Name",
     *       required=false,
     *       type="string",
     *       paramType="form",
     *       allowMultiple=false
     *     ),
     *     @SWG\Parameter(
     *       name="last_name",
     *       description="Last Name",
     *       required=false,
     *       type="string",
     *       paramType="form",
     *       allowMultiple=false
     *     ),
     *     @SWG\Parameter(
     *       name="email",
     *       description="Email",
     *       required=false,
     *       type="string",
     *       paramType="form",
     *       allowMultiple=false
     *     ),
     *     @SWG\Parameter(
     *       name="phone",
     *       description="Phone",
     *       required=false,
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

        $validationRules = [
            'login'       => 'required|unique:customers,login',
            'password'    => 'required'
        ];

        if (isset($inputs['email'])) {
            $validationRules['email'] = 'required|email|unique:customers,email';
        }

        $validator = Validator::make($inputs, $validationRules);

        if ($validator->fails()) {
            $response = ['error' => $validator->errors()];
            $statusCode = 500;
        } else {
            $params = [
                'name'        => (string)@$inputs['name'],
                'second_name' => (string)@$inputs['second_name'],
                'last_name'   => (string)@$inputs['last_name'],
                'email'       => (string)@$inputs['email'],
                'phone'       => (string)@$inputs['phone'],
                'login'       => $inputs['login'],
                'password'    => $inputs['password']
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
                'password' => md5($inputs['password'])
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
            foreach ($ordersModel->get() as $orderModel) {
                $response[] = (new ModelViews\Order($orderModel))->get();
            }
        }

        return \Response::json($response, $statusCode);
    }

    /**
     * @SWG\Api(
     *   path="/customers/{customerId}/photo",
     *   @SWG\Operation(
     *     nickname="Get all customer photos",
     *     method="GET",
     *     summary="Will return all photos of selected customer",
     *     notes="",
     *     type="Photo",
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
     *     @SWG\ResponseMessage(code=404, message="Customer not found"),
     *     @SWG\ResponseMessage(code=500, message="Internal server error")
     *   )
     * )
     */
    public function getPhoto($customerId)
    {
        $statusCode = 200;
        $response = [];
        $customer = Models\Customer::find($customerId);

        if ($customer->count() == 0) {
            $statusCode = 404;
        } else {
            foreach ($customer->photos as $photo) {
                $response[] = (new ModelViews\Photo($photo))->get();
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
     *   path="/customers/{customerId}/order_calculate",
     *   @SWG\Operation(
     *     nickname="Calculate order",
     *     method="POST",
     *     summary="Calculate order",
     *     notes="Returns order price",
     *     type="OrderCalculate",
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
     *       type="OrdersCalculateBody",
     *       paramType="body",
     *       allowMultiple=false
     *     ),
     *     @SWG\ResponseMessage(code=500, message="Internal server error")
     *   )
     * )
     */
    public function calculateOrder($customerId)
    {
        // NOTE! that customer id need for features price breaks
        $statusCode = 200;
        $params = \Input::all();
        $order = [
            'total' => 0,
            'items' => []
        ];
        if (isset($params['items'])) {

            foreach ($params['items'] as $item) {
                $orderItem = [
                    'format_id' => isset($item['format_id']) ? $item['format_id'] : 0,
                    'qty' => isset($item['qty']) ? $item['qty'] : 0,
                    'addons' => []
                ];

                $formatModel = Models\Format::find($item['format_id']);
                if (is_null($formatModel)) {
                    return \Response::json(['error' => 'Format does\'t exists'], 500);
                }
                if (isset($item['addons'])) {
                    foreach ($item['addons'] as $addon) {
                        $orderItem['addons'][] = [
                            'id' => isset($addon['id']) ? $addon['id'] : 0,
                            'qty' => isset($addon['qty']) ? $addon['qty'] : 0,
                        ];

                        $addonModel = Models\Addon::find(@$addon['id']);

                        if (is_null($addonModel)) {
                            return \Response::json(['error' => 'Addon does\'t exists'], 500);
                        }
                    }
                }

                $order['items'][] = $orderItem;
            }

            $orderModal = new Models\Order();
            $order = $orderModal->getRepository()->fillOrderPrices($order);
            return \Response::json($order, $statusCode);
        } else {
            return \Response::json($order, $statusCode);
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
        $params['customer_id'] = $customerId;

        if ($params) {
            $errors = [];
            $mainValidator = Validator::make($params, [
                'customer_id' => 'required|numeric|exists:customers,id',
                'items' => 'required|array',
                'delivery' => 'required|array'
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
                        'format_id' => 'required|numeric|exists:formats,id'
                    ]);

                    if (!empty($params['addons'])) {
                        foreach ($item['addons'] as $addon) {
                            $itemsAddonsValidator[$itemKey][] = Validator::make($addon, [
                                'id' => 'required|numeric|exists:addons,id',
                                'qty' => 'required|numeric|min:1'
                            ]);
                        }
                    }
                }

                foreach ($itemsValidator as $itemKey => $validator) {
                    if ($validator->fails()) {
                        $errors['items'][$itemKey + 1] = $validator->errors();
                    } else {
                        if (!empty($params['addons'])) {
                            foreach ($itemsAddonsValidator[$itemKey] as $addonKey => $validator) {
                                if ($validator->fails()) {
                                    $errors['items'][$itemKey + 1]['addons'][$addonKey + 1] = $validator->errors();
                                }
                            }
                        }
                    }
                }

                $validator = Validator::make($params['delivery'], [
                    'country'     => 'required|alpha|max:100',
                    'city'        => 'required|alpha|max:100',
                    'phone'       => 'required|regex:"^([0-9\s\-\+\(\)]{5,})$"',
                    'zip_code'    => 'required|regex:"^\d{5}(?:[-\s]\d{4})?$"',
                    'name'        => 'required',
                    'street'      => 'required'
                ]);

                if ($validator->fails()) {
                    $errors['delivery'] = $validator->errors();
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
     *     nickname="Delete customers address",
     *     method="DELETE",
     *     summary="Find customers address by ID and delete it",
     *     notes="Will delete customer adress from the database",
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
    public function deleteAddressById($customerId, $id)
    {
        $statusCode = 200;
        $response = [];

        try {
            $customersAddressModel = Models\CustomersAddress::where('id', $id)
                ->where('customer_id', $customerId)
                ->first();

            if (!isset($customersAddressModel)) {
                throw new ModelNotFoundException();
            }

            $customersAddressModel->delete();

            return $response;
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
     *   path="/customers/{customerId}/address/{id}",
     *   @SWG\Operation(
     *     nickname="Update customer address",
     *     method="PATCH",
     *     summary="Update customer address",
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
     *     @SWG\Parameter(
     *       name="country",
     *       description="Country",
     *       required=false,
     *       type="string",
     *       paramType="form",
     *       allowMultiple=false
     *     ),
     *     @SWG\Parameter(
     *       name="city",
     *       description="City",
     *       required=false,
     *       type="string",
     *       paramType="form",
     *       allowMultiple=false
     *     ),
     *     @SWG\Parameter(
     *       name="phone",
     *       description="Phone",
     *       required=false,
     *       type="string",
     *       paramType="form",
     *       allowMultiple=false
     *     ),
     *     @SWG\Parameter(
     *       name="zip_code",
     *       description="Zip Code",
     *       required=false,
     *       type="string",
     *       paramType="form",
     *       allowMultiple=false
     *     ),
     *     @SWG\Parameter(
     *       name="name",
     *       description="Name",
     *       required=false,
     *       type="string",
     *       paramType="form",
     *       allowMultiple=false
     *     ),
     *     @SWG\Parameter(
     *       name="street",
     *       description="Street",
     *       required=false,
     *       type="string",
     *       paramType="form",
     *       allowMultiple=false
     *     ),
     *     @SWG\ResponseMessage(code=500, message="Internal server error")
     *   )
     * )
     */
    public function updateAddress($customerId, $id)
    {
        $statusCode = 200;
        $response = [];
        $inputs = \Input::all();
        $inputs['id'] = $id;

        try {

            $validationRules = [
                'id' => 'required|numeric'
            ];

            if (isset($inputs['country']))
                $validationRules['country'] = 'required|alpha|max:100';

            if (isset($inputs['city']))
                $validationRules['city'] = 'required|alpha|max:100';

            if (isset($inputs['phone']))
                $validationRules['phone'] = 'required|regex:"^([0-9\s\-\+\(\)]{5,})$"';

            if (isset($inputs['zip_code']))
                $validationRules['zip_code'] = 'required|regex:"^\d{5}(?:[-\s]\d{4})?$"';

            $validator = Validator::make($inputs, $validationRules);

            if ($validator->fails()) {
                $response = ['error' => $validator->errors()];
                $statusCode = 500;
            } else {
                $customersAddressModel = Models\CustomersAddress::where('id', $id)
                    ->where('customer_id', $customerId)
                    ->first();

                if (!isset($customersAddressModel) && $customersAddressModel->id < 1) {
                    throw new ModelNotFoundException();
                }

                foreach ($inputs as $key => $value) {
                    switch ($key) {
                        case 'country':
                        case 'city':
                        case 'phone':
                        case 'zip_code':
                        case 'name':
                        case 'street':
                            $customersAddressModel->$key = $value;
                            break;
                    }
                }

                $customersAddressModel->save();
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
            'phone'       => 'required|regex:"^([0-9\s\-\+\(\)]{5,})$"',
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

    /**
     * @SWG\Api(
     *   path="/customers/{customerId}/photo",
     *   @SWG\Operation(
     *     nickname="Add new photo",
     *     method="POST",
     *     summary="Add new photo",
     *     notes="Returns photo",
     *     type="Photo",
     *     authorizations={},
     *     @SWG\Parameter(
     *       name="customerId",
     *       description="Customer ID",
     *       required=true,
     *       type="integer",
     *       format="int64",
     *       paramType="path",
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
    public function addPhoto($customerId)
    {
        $statusCode = 200;

        $inputs = \Input::all();
        $inputs['customer_id'] = $customerId;

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