<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ApiFormatsTest extends TestCase
{

    public function testGetAll()
    {
        $response = $this->call('GET', '/api/v1/formats');
        $this->assertEquals(200, $response->status());

        $responseData = json_decode($response->getContent());

        $this->assertEquals(true, (count($responseData) > 0));

        foreach ($responseData as $format) {

            $format = (array) $format;
            $this->assertArrayHasKey('id', $format);
            $this->assertArrayHasKey('width', $format);
            $this->assertArrayHasKey('height', $format);
            $this->assertArrayHasKey('price', $format);

        }
    }

}
