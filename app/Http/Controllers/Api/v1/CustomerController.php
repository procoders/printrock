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
}