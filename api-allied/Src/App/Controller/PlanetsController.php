<?php

namespace Src\App\Controller;

use Src\Lib\HttpRequest;

class PlanetsController extends Controller {

    private $httpRequest;

    private static $relativeUri = 'planets';

    function __construct()
    {
        $this->httpRequest = new HttpRequest($_ENV['BASE_URI']);   
    }

    /**
     * Retorna lista paginada.
     */
    public function getPlanetByID(Array $params)
    {
        $id = ($params['id'] ? $params['id'] : null);

        $list = $this->httpRequest->get(self::$relativeUri . '/' . $id);

        if ($list['success']) {
            return \Src\Responses\Response::responseJson($list['data'], true);
        }

        throw new \Exception(parent::$internalError);
    }
}