<?php declare(strict_types=1);

namespace App\Core;

use App\Core\Response\Redirect;
use App\Core\Response\Response;
use App\Core\Response\View;
use FastRoute;

class Router
{
    private Response $response;
    public function route()
    {
        $dispatcher = FastRoute\simpleDispatcher(function (FastRoute\RouteCollector $r) {
            $routes = require_once '../routes.php';

            foreach ($routes as $route) {
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
                // ... 404 Not Found
                break;
            case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
                $allowedMethods = $routeInfo[1];
                // ... 405 Method Not Allowed
                break;
            case FastRoute\Dispatcher::FOUND:
                $handler = $routeInfo[1];
                $vars = $routeInfo[2];

                [$controller, $method] = $handler;
                $this->response = (new $controller)->{$method}($vars);
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
            Session::unflash();
        }
    }

}