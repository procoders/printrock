<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ApiAddonsTypesTest extends TestCase
{
    public function testGetAll() {
        $response = $this->call('GET', '/api/v1/addons_types');
        $this->assertEquals(200, $response->status());

        $responseData = json_decode($response->getContent(), true);

        foreach ($responseData as $addon) {
            $this->assertArrayHasKey('id', $addon);
            $this->assertArrayHasKey('code', $addon);
            $this->assertArrayHasKey('name', $addon);
        }
    }

    public function testGetById() {
        $response = $this->call('GET', '/api/v1/addons_types/1');
        $this->assertEquals(200, $response->status());

        $addon = json_decode($response->getContent(), true);

        $this->assertArrayHasKey('id', $addon);
        $this->assertArrayHasKey('code', $addon);
        $this->assertArrayHasKey('name', $addon);

        // validate for unknown addon type
        $response = $this->call('GET', '/api/v1/addons_types/999999');
        $this->assertEquals(404, $response->status());
    }
}
