<?php

namespace Src\App\Controller;

use Src\Lib\HttpRequest;

class PeoplesController extends Controller {

    private $httpRequest;

    private static $relativeUri = 'people';

    function __construct()
    {
        $this->httpRequest = new HttpRequest($_ENV['BASE_URI']);   
    }

    /**
     * Retorna lista paginada.
     */
    public function getListByPage(Array $params)
    {
        $page = ($params['page'] ? $params['page'] : 1);

        $finalParams = [
            'page' => $page
        ];

        $list = $this->httpRequest->get(self::$relativeUri, $finalParams);

        if ($list['success']) {
            return \Src\Responses\Response::responseJson($list['data'], true);
        }

        throw new \Exception(parent::$internalError);
    }
}