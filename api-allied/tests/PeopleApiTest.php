<?php

use PHPUnit\Framework\TestCase;

class PeopleApiTest extends TestCase
{
    private $http;

    private static $baseUri = 'http://localhost:8000/';

    public function setUp(): void
    {
        $this->http = new GuzzleHttp\Client(['base_uri' => self::$baseUri]);
    }

    public function tearDown(): void
    {
        $this->http = null;
    }

    public function testGet(): void
    {
        $this->Retorno_Positivo();
        $this->Retorno_Vazio();
    }

    private function Retorno_Positivo(): void
    {
        $response = $this->http->request('GET', 'people/1');

        $this->assertEquals(200, $response->getStatusCode());

        $contentType = $response->getHeaders()["Content-Type"][0];
        $this->assertEquals("application/json", $contentType);

        $dataReturn = json_decode($response->getBody());

        $this->assertEquals(true, isset($dataReturn->results));
    }

    private function Retorno_Vazio(): void
    {
        $response = $this->http->request('GET', 'people/123456789');

        $this->assertEquals(200, $response->getStatusCode());

        $contentType = $response->getHeaders()["Content-Type"][0];
        $this->assertEquals("application/json", $contentType);

        $dataReturn = json_decode($response->getBody());

        $this->assertEquals(false, $dataReturn->success);
    }
}