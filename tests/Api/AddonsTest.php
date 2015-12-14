<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ApiAddonsTest extends TestCase
{

    protected $_availablePriceTypes = [
        'price',
        'percent'
    ];

    public function testGetAll() {
        $response = $this->call('GET', '/api/v1/addons');
        $this->assertEquals(200, $response->status());

        $responseData = json_decode($response->getContent(), true);

        foreach ($responseData as $addon) {
            $this->assertArrayHasKey('id', $addon);
            $this->assertArrayHasKey('name', $addon);
            $this->assertArrayHasKey('image', $addon);
            $this->assertEquals(true, in_array($addon['price_type'], $this->_availablePriceTypes));
            $this->assertArrayHasKey('price', $addon);
            $this->assertArrayHasKey('type', $addon);
            $this->assertArrayHasKey('id', $addon['type']);
            $this->assertArrayHasKey('code', $addon['type']);
            $this->assertArrayHasKey('name', $addon['type']);
        }

        // validate price type filter

        foreach ($this->_availablePriceTypes as $priceType) {
            $response = $this->call('GET', '/api/v1/addons?price_type=' . $priceType);
            $this->assertEquals(200, $response->status());

            $responseData = json_decode($response->getContent(), true);

            foreach ($responseData as $addon) {
                $this->assertArrayHasKey('id', $addon);
                $this->assertArrayHasKey('name', $addon);
                $this->assertArrayHasKey('image', $addon);
                $this->assertEquals($addon['price_type'], $priceType);
                $this->assertArrayHasKey('price', $addon);
                $this->assertArrayHasKey('type', $addon);
                $this->assertArrayHasKey('id', $addon['type']);
                $this->assertArrayHasKey('code', $addon['type']);
                $this->assertArrayHasKey('name', $addon['type']);
            }
        }

        // validate type filter
        foreach ([1,2] as $addonType) {
            $response = $this->call('GET', '/api/v1/addons?type_id=' . $addonType);
            $this->assertEquals(200, $response->status());

            $responseData = json_decode($response->getContent(), true);

            foreach ($responseData as $addon) {
                $this->assertArrayHasKey('id', $addon);
                $this->assertArrayHasKey('name', $addon);
                $this->assertArrayHasKey('image', $addon);
                $this->assertArrayHasKey('price', $addon);
                $this->assertArrayHasKey('type', $addon);
                $this->assertEquals($addon['type']['id'], $addonType);
                $this->assertArrayHasKey('code', $addon['type']);
                $this->assertArrayHasKey('name', $addon['type']);
            }
        }

    }

    public function getById() {
        $response = $this->call('GET', '/api/v1/addons/1');
        $this->assertEquals(200, $response->status());

        $addon = json_decode($response->getContent(), true);
        $this->assertArrayHasKey('id', $addon);
        $this->assertArrayHasKey('name', $addon);
        $this->assertArrayHasKey('image', $addon);
        $this->assertEquals(true, in_array($addon['price_type'], $this->_availablePriceTypes));
        $this->assertArrayHasKey('price', $addon);
        $this->assertArrayHasKey('type', $addon);
        $this->assertArrayHasKey('id', $addon['type']);
        $this->assertArrayHasKey('code', $addon['type']);
        $this->assertArrayHasKey('name', $addon['type']);

        // validate unknown addon
        $response = $this->call('GET', '/api/v1/addons/99999999');
        $this->assertEquals(404, $response->status());
    }
}
