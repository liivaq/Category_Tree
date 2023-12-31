<?php declare(strict_types=1);

namespace App\Core;

use App\Core\Response\JsonResponse;
use App\Core\Response\Redirect;
use App\Core\Response\Response;
use App\Core\Response\View;
use FastRoute;

class Router
{
    private Response $response;
    private array $routes;
    public function __construct()
    {
        $this->routes = require_once '../routes.php';

    }

    public function route()
    {
        $dispatcher = FastRoute\simpleDispatcher(function (FastRoute\RouteCollector $r) {

            foreach ($this->routes as $route) {
                [$method, $route, $handler] = $route;
                $r->addRoute($method, $route, $handler);
            }
        });

        $httpMethod = $_SERVER['REQUEST_METHOD'];
        $uri = $_SERVER['REQUEST_URI'];

        if (false !== $pos = strpos($uri, '?')) {
            $uri = substr($uri, 0, $pos);
        }
        $uri = rawurldecode($uri);

        $routeInfo = $dispatcher->dispatch($httpMethod, $uri);

        switch ($routeInfo[0]) {
            case FastRoute\Dispatcher::NOT_FOUND:
                $this->response = new View('errors/404');
                break;
            case FastRoute\Dispatcher::FOUND:
                $handler = $routeInfo[1];
                $vars = $routeInfo[2];

                [$controller, $method] = $handler;
                $this->response = Container::build()->get($controller)->{$method}($vars);
        }
        return $this;
    }

    public function resolve()
    {
        if ($this->response instanceof Redirect) {
            $this->response->redirect();
        }

        if ($this->response instanceof View) {
            echo (new Renderer())->render($this->response);
        }

        if ($this->response instanceof JsonResponse) {
            echo $this->response->getJson();
        }

        Session::unflash();
    }

}