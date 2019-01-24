<?php

namespace App\Kernel\Helpper;

use App\Kernel\Http\Request;
use App\Kernel\Http\Response;
use App\Kernel\Http\Controller;
use App\Kernel\Http\ErrorController;
use App\Kernel\Support\Authenticator;

class Router
{
    private $routeMap;
    private static $regexPatters = [

        'number' => '\d+',
        'string' => '\w+',
    ];

    public function __construct(array $routes)
    {
        $this->routeMap = $routes;
    }

    public function route(Request $request) : Response
    {
        $path = $request->getRoute();

        foreach ($this->routeMap as $route => $info) 
        {
            $regexRoute = $this->getRegexRoute($route, $info);

            if (preg_match($regexRoute, $path)) 
            {
                return $this->executeController($route, $path, $info, $request);
            }
        }

        $errorController = new ErrorController($request);
        return $errorController->notFound();
    }

    public function getRegexRoute(string $route, array $info ) : string 
    {

        $route = str_replace('/', '\/', $route);

        if (isset($info['params'])) 
        {
            foreach ($info['params'] as $name => $type) 
            {
                $route = str_replace(':' . $name, self::$regexPatters[$type], $route);
            }
        }

        return "@^$route$@";
    }

    public function extractParams(string $route, string $path) : array 
    {
        $params = [];

        $pathParts = explode('/', $path);

        $routeParts = explode('/', $route);

        foreach ($routeParts as $key => $routePart) 
        {
            if (strpos($routePart, ':') === 0) 
            {
                $name = substr($routePart, 1);
                $params[$name] = $pathParts[$key];
            }
        }

        return $params;
    }

    private function executeController(string $route, string $path, array $info, Request $request): Response 
    {
        $controllerName = '\App\Controllers\\' . $info['controller'];

        $controller = new $controllerName($request);

        if (isset($info['auth']) && $info['auth']) 
        {
            $authInstance = new Authenticator($request);

            if (!$authInstance->authenticateUser())
            {
                return $authInstance->faill();
            }
        }

        $params = $this->extractParams($route, $path);

        return call_user_func_array([$controller, $info['action']], $params);
    }
}