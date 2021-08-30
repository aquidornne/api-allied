<?php

namespace Src\Lib;

use GuzzleHttp\Client as Client;
use GuzzleHttp\Psr7\Request as Request;
use GuzzleHttp\Exception\ClientException as ClientException;

class HttpRequest {
    protected $_client;

    function __construct(String $baseUri)
    {
        $this->_client = new Client([
            'header' => [
                'Accept' => 'application/json',
                'Content-Type' => 'application/x-www-form-urlencoded'
            ],
            'base_uri' => $baseUri,
            'timeout'  => 30
        ]);
    }

    public function get(
        String $endpoint,
        Array $params = []
    ) {
        try {
            if (!empty($params)) {
                $endpoint = $endpoint . '?' . http_build_query($params);
            }

            $response = $this->_client->get($endpoint);

            return self::prepereResult($response);
        } catch (ClientException $e) {
            return self::prepareFailedResult($e->getCode());
        }
    }

    public function post(
        String $endpoint,
        Array $params = []
    ) {
        try {
            $finalParams = [
                'body' => $params
            ];
    
            $response = $this->_client->post(
                $endpoint,
                $finalParams
            );
    
            return self::prepereResult($response);
        } catch (ClientException $e) {
            return self::prepareFailedResult($e->getCode());
        }
    }

    private static function prepereResult(Object $response)
    {
        $status = $response->getStatusCode();

        if (in_array($status, [200, 201])) {
            $data = $response->getBody()->getContents();
            return self::prepareSuccessResult($data);
        }

        return self::prepareFailedResult($status);
    }

    private static function prepareSuccessResult($data)
    {
        return [
            'data' => json_decode($data),
            'success' => true
        ];
    }

    private static function prepareFailedResult(Int $statusCode)
    {
        return [
            'status' => $statusCode,
            'success' => false
        ];
    }
}