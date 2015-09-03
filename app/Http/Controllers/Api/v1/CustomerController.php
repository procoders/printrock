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
 *     resourcePath="/customer",
 *     basePath="/api/v1"
 * )
 */
class CustomerController extends Controller {

    /**
     * @SWG\Api(
     *   path="/customer/get/{id}",
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
     *   path="/customer/add",
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
        $response = [];

        $inputs = \Input::all();

        $validator = Validator::make($inputs, [
            'name'        => 'required',
            'second_name' => 'required',
            'last_name'   => 'required',
            'email'       => 'required',
            'phone'       => 'required',
            'login'       => 'required',
            'password'    => 'required'
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
}