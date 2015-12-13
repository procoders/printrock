<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ApiCustomersTest extends TestCase
{

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

    public function testGetCustomerAddress()
    {
        $response = $this->call('GET', '/api/v1/customers/1/address');
        $this->assertEquals(200, $response->status());

        $addressCollection = json_decode($response->getContent(), true);

        foreach ($addressCollection as $address) {
            $this->_validateCustomAddress($address);
        }
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
