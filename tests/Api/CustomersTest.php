<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ApiCustomersTest extends TestCase
{

    public function testCreateNewCustomer()
    {
        // validate new customer creation
        $customerData = [
            'login' => 'test_customer',
            'password' => 'test_customer'
        ];

        $response = $this->call('POST', '/api/v1/customers/', $customerData);
        $this->assertEquals(200, $response->status());

        $responseData = json_decode($response->getContent(), true);
        $this->assertEquals($responseData['login'], $customerData['login']);
        // remove garbage
        \App\Models\Customer::find($responseData['id'])->delete();

        // validate that all data can be saved
        $customerData = [
            'login' => 'test_customer',
            'password' => 'test_customer',
            'name' => 'test_customer',
            'second_name' => 'test_customer',
            'last_name' => 'test_customer',
            'phone' => '777-777-77',
            'email' => 'test@test.com'
        ];

        $response = $this->call('POST', '/api/v1/customers/', $customerData);
        $this->assertEquals(200, $response->status());

        $responseData = json_decode($response->getContent(), true);

        foreach ($customerData as $key => $value) {
            switch ($key) {
                case 'password':
                    break;
                default:
                    $this->assertEquals($value, $responseData[$key]);
                    break;
            }
        }
        // remove garbage
        \App\Models\Customer::find($responseData['id'])->delete();

        // validate for incorrect email
        $customerData['email'] = 'trash';
        $response = $this->call('POST', '/api/v1/customers/', $customerData);
        $this->assertEquals(500, $response->status());

    }

    public function testLogin()
    {
        // validate for incorrect login
        $response = $this->call('POST', '/api/v1/customers/login', ['login' => 'bob', 'password' => 'bobby']);
        $this->assertEquals(404, $response->status());

        // validate for incorrect password
        $response = $this->call('POST', '/api/v1/customers/login', ['login' => 'bobby', 'password' => 'bob']);
        $this->assertEquals(404, $response->status());

        // validate for correct login
        $response = $this->call('POST', '/api/v1/customers/login', ['login' => 'bobby', 'password' => 'bobby']);
        $this->assertEquals(200, $response->status());
        $customer = json_decode($response->getContent(), true);
        $this->_validateCustomerObject($customer);
    }

    public function testGetCustomerAddress()
    {
        $response = $this->call('GET', '/api/v1/customers/1/address');
        $this->assertEquals(200, $response->status());

        $addressCollection = json_decode($response->getContent(), true);

        foreach ($addressCollection as $address) {
            $this->_validateCustomAddress($address);
        }
    }

    public function testAddAddress()
    {
        // create cutomer
        $customerData = [
            'login' => 'test_customer',
            'password' => 'test_customer'
        ];

        $response = $this->call('POST', '/api/v1/customers/', $customerData);
        $this->assertEquals(200, $response->status());
        $customerData = json_decode($response->getContent());

        $addressData = [
            "country" => "Germany",
            "city" => "Munich",
            "phone" => "55-66-77",
            "zip_code" => 12345,
            "name" => "Wolter",
            "street" => "Some street"
        ];

        $response = $this->call('POST', '/api/v1/customers/' . $customerData->id . '/address', $addressData);
        $this->assertEquals(200, $response->status());
        $addressDataResponse = json_decode($response->getContent(), true);

        foreach ($addressDataResponse as $key => $value) {
            $this->assertEquals($value, $addressDataResponse[$key]);
        }

        // validate for working validations
        foreach ($addressData as $key => $value) {
            $customData = $addressData;
            $customData[$key] = '';
            $response = $this->call('POST', '/api/v1/customers/' . $customerData->id . '/address', $customData);
            $this->assertEquals(500, $response->status());
        }

        // validate for phone validations
        $customData = $addressData;
        $customData['phone'] = 'some fake data';
        $response = $this->call('POST', '/api/v1/customers/' . $customerData->id . '/address', $customData);
        $this->assertEquals(500, $response->status());

        // validate for zip validation
        $customData = $addressData;
        $customData['zip_code'] = 'some fake data';
        $response = $this->call('POST', '/api/v1/customers/' . $customerData->id . '/address', $customData);
        $this->assertEquals(500, $response->status());
    }

    public function testGetCustomerAddressByCustomerIdAndAddressId()
    {
        $response = $this->call('GET', '/api/v1/customers/1/address/1');
        $this->assertEquals(200, $response->status());

        $address = json_decode($response->getContent(), true);
        $this->_validateCustomAddress($address);


        // validate for unknown addon type
        $response = $this->call('GET', '/api/v1/customers/90/address/1');
        $this->assertEquals(404, $response->status());
        $response = $this->call('GET', '/api/v1/customers/1/address/3');
        $this->assertEquals(404, $response->status());
    }

    protected function _createAnFakeOrder()
    {
/*
 * {
  "customer_id": 0,
  "total": 0,
  "items": [
    {
      "photo_id": 0,
      "qty": 0,
      "price_per_item": 0,
      "format_id": 0,
      "addons": [
        {
          "id": 0,
          "qty": 0
        }
      ]
    }
  ],
  "comment": ""
}
 */
    }

    public function testCustomerGetPhotos()
    {
        $response = $this->call('GET', '/api/v1/customers/1/photo');
        $this->assertEquals(200, $response->status());

        $photos = json_decode($response->getContent(), true);

        foreach($photos as $photo) {
            $this->assertArrayHasKey('id', $photo);
            $this->assertArrayHasKey('image', $photo);
        }
    }

    public function testGetCustomerOrders()
    {

    }

    public function testCreateNewOrder()
    {

    }

    public function testGetCustomerOrder()
    {

    }

    public function testCustomerGetById()
    {
        $response = $this->call('GET', '/api/v1/customers/1');
        $this->assertEquals(200, $response->status());

        $customer = json_decode($response->getContent(), true);
        $this->_validateCustomerObject($customer);


        // validate for unknown addon type
        $response = $this->call('GET', '/api/v1/customers/999999');
        $this->assertEquals(404, $response->status());
    }

    protected function _validateCustomerObject($customer)
    {
        $this->assertArrayHasKey('id', $customer);
        $this->assertArrayHasKey('name', $customer);
        $this->assertArrayHasKey('second_name', $customer);
        $this->assertArrayHasKey('last_name', $customer);
        $this->assertArrayHasKey('email', $customer);
        $this->assertArrayHasKey('login', $customer);

        $this->assertEquals(true, (count($customer['addresses']) > 0));
        foreach ($customer['addresses'] as $address) {
            $this->_validateCustomAddress($address);
        }
    }

    protected function _validateCustomAddress($address)
    {
        $this->assertArrayHasKey('id', $address);
        $this->assertArrayHasKey('country', $address);
        $this->assertArrayHasKey('city', $address);
        $this->assertArrayHasKey('phone', $address);
        $this->assertArrayHasKey('zip_code', $address);
        $this->assertArrayHasKey('name', $address);
        $this->assertArrayHasKey('street', $address);
    }

}
