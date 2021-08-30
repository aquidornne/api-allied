<?php

namespace Src\Responses;

class Response {

    /**
     * Resgate do objeto json com as mensagens pertinentes a ocasião.
     */
    public static function getJson(
        Int $status,
        String $msg = null
    ) {
        $file = dirname(__FILE__) . "/$status.json";

        if (file_exists($file)) {
            $json = file_get_contents($file);
        } else {
            $json = file_get_contents(dirname(__FILE__) . '/500.json');
        }

        $jsonArr = json_decode($json);
        $jsonArr->message = $msg;

        self::responseJson(json_encode($jsonArr));
    }

    public static function responseJson($data, $encode = false)
    {
        header('Content-type: application/json');
        echo ($encode ? json_encode($data) : $data);
        exit;
    }
}