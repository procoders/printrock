<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ApiOrdersStatusTest extends TestCase
{

    public function testGetAllOrdersStatuses()
    {

        $response = $this->call('GET', '/api/v1/orders_status/');

        $this->assertEquals(200, $response->status());

        $responseData = json_decode($response->getContent());

        foreach ($responseData as $orderStatus) {
            $orderStatus = (array) $orderStatus;

            $this->assertArrayHasKey('id', $orderStatus);
            $this->assertArrayHasKey('code', $orderStatus);
            $this->assertArrayHasKey('default', $orderStatus);
            $this->assertArrayHasKey('descriptions', $orderStatus);

            $this->assertEquals(count($orderStatus['descriptions']), 3);
        }

        // validate language filter
        $response = $this->call('GET', '/api/v1/orders_status/?language_id=1');

        $this->assertEquals(200, $response->status());

        $responseData = json_decode($response->getContent());

        foreach ($responseData as $orderStatus) {
            $orderStatus = (array) $orderStatus;

            $this->assertEquals(count($orderStatus['descriptions']), 1);
        }

    }

    public function testGetOrderStatusById()
    {
        $response = $this->call('GET', '/api/v1/orders_status/1');

        $this->assertEquals(200, $response->status());

        $orderStatus = json_decode($response->getContent());

        $orderStatus = (array) $orderStatus;

        $this->assertArrayHasKey('id', $orderStatus);
        $this->assertArrayHasKey('code', $orderStatus);
        $this->assertArrayHasKey('default', $orderStatus);
        $this->assertArrayHasKey('descriptions', $orderStatus);

        $this->assertEquals(count($orderStatus['descriptions']), 3);

        // validate language filter
        $response = $this->call('GET', '/api/v1/orders_status/1?language_id=1');

        $this->assertEquals(200, $response->status());

        $orderStatus = json_decode($response->getContent());

        $orderStatus = (array) $orderStatus;

        $this->assertEquals(count($orderStatus['descriptions']), 1);

    }

}
