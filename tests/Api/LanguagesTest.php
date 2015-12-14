<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ApiLanguagesTest extends TestCase
{

    public function testGetAll()
    {
        $response = $this->call('GET', '/api/v1/languages');
        $this->assertEquals(200, $response->status());

        $responseData = json_decode($response->getContent(), true);

        $this->assertEquals(count($responseData), 3);

        foreach ($responseData as $language) {
            $this->assertArrayHasKey('id', $language);
            $this->assertArrayHasKey('code', $language);
            $this->assertArrayHasKey('name', $language);
        }
    }

    public function testGetLanguageById()
    {
        $response = $this->call('GET', '/api/v1/languages/1');
        $this->assertEquals(200, $response->status());

        $responseData = json_decode($response->getContent(), true);

        $this->assertArrayHasKey('id', $responseData);
        $this->assertArrayHasKey('code', $responseData);
        $this->assertArrayHasKey('name', $responseData);

        // test for unknown language id

        $response = $this->call('GET', '/api/v1/languages/0');
        $this->assertEquals(404, $response->status());
    }

}
