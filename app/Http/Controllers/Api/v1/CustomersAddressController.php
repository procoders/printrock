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
 *     resourcePath="/customers_address",
 *     basePath="/api/v1"
 * )
 */
class CustomersAddressController extends Controller
{

    /**
     * @SWG\Api(
     *   path="/customers_address/{id}",
     *   @SWG\Operation(
     *     nickname="Get customers address",
     *     method="GET",
     *     summary="Find customers address by ID",
     *     notes="Returns customers address",
     *     type="CustomersAddress",
     *     authorizations={},
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
                $customersAddressModel = Models\CustomersAddress::where('id', $id)->first();
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
     *   path="/customers_address/",
     *   @SWG\Operation(
     *     nickname="Add new cusromers address",
     *     method="POST",
     *     summary="Add new customers address",
     *     notes="Returns customers address",
     *     type="CustomersAddress",
     *     authorizations={},
     *     @SWG\Parameter(
     *       name="customer_id",
     *       description="Customer ID",
     *       required=true,
     *       type="integer",
     *       format="int64",
     *       paramType="form",
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
    public function add()
    {
        $statusCode = 200;

        $inputs = \Input::all();

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
                'customer_id' => $inputs['customer_id'],
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