<?php
use FastRoute\RouteCollector;


$dispatcher = FastRoute\simpleDispatcher(function(RouteCollector $r) {
    $routes = include  __DIR__.'/../src/routes.php';
    foreach ($routes as $route) {
        $r->addRoute($route[0], $route[1], $route[2]);
    }
});

$httpMethod = $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];

$routeInfo = $dispatcher->dispatch($httpMethod, $uri);

switch ($routeInfo[0]) {
    case FastRoute\Dispatcher::NOT_FOUND:
        // Tratamento para rota não encontrada
        throw new Exception('Rota não encontrada');
        break;
    case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
        // Tratamento para método não permitido
        throw new Exception('Método não permitido');
        break;
    case FastRoute\Dispatcher::FOUND:
        $handler = $routeInfo[1];
        $vars = $routeInfo[2];
        $controller = new $handler[0];
        $method = $handler[1];
        $controller->$method($vars);
        break;
}

?>