<?php

use Src\Responses\Response;

#################################- Definição de rotas -################################# 
function routes()
{
    return [
        'getListByPage' => 'Src\App\Controller\PeoplesController',
        'getPlanetByID' => 'Src\App\Controller\PlanetsController'
    ];
}

$dispatcher = FastRoute\simpleDispatcher(function(FastRoute\RouteCollector $r) {
    $r->addRoute('GET', '/people/{page}', 'getListByPage');
    $r->addRoute('GET', '/planets/{id}', 'getPlanetByID');
});
########################################################################################

$httpMethod = $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];

if (false !== $pos = strpos($uri, '?')) {
    $uri = substr($uri, 0, $pos);
}

$uri = rawurldecode($uri);

$routeInfo = $dispatcher->dispatch($httpMethod, $uri);

switch ($routeInfo[0]) {
    case FastRoute\Dispatcher::NOT_FOUND:
        Response::getJson(404);
        break;
    case FastRoute\Dispatcher::FOUND:
        handler($routeInfo[1], $routeInfo[2]);
        break;
}

// Executa a função definida na busca de rotas.
function handler($handler, $vars)
{
    try {
        $routes = routes();
        $class = new $routes[$handler]();
        $class->$handler($vars);
    } catch (Exception $e) {
        Response::getJson(500, $e->getMessage());
    }
}