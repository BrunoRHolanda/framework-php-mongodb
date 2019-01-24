<?php

namespace App\Kernel\Http;

use App\Kernel\Support\Collection;

class Request 
{
    private $method;
    private $host;
    private $port;
    private $route;
    private $params;
    private $authorization;

    public function __construct(
        string $method,
        string $route,
        string $host, 
        string $port,
        string $authorization = null,
        Collection $params = null
    )
    {
        $this->method = $method;
        $this->route = $route;
        $this->authorization = $authorization;
        $this->host = $host;
        $this->port = $port;
        $this->params = $params;
    }

    public static function capture(): Request
    {
        $method = $_SERVER['REQUEST_METHOD'];
        $route = $_SERVER['REQUEST_URI'];
        $authorization = $_SERVER['HTTP_AUTHORIZATION'] ?? null;
        $host = $_SERVER['HTTP_HOST'];
        $port = $_SERVER['SERVER_PORT'];
        $params = null;

        if ($method == 'GET')
        {
            $params = new Collection($_GET);
        } 
        else 
        {
            if (isset($_SERVER['CONTENT_TYPE']) && $_SERVER['CONTENT_TYPE'] == 'application/json')
            {
                $arr = json_decode(file_get_contents('php://input'), true);
                $params = new Collection($arr);
            }
            else 
            {
                $params = new Collection($_POST);
            }
        }

        return new Request($method, $route, $host, $port, $authorization, $params);
    }

    public function input(string $key)
    {
        return $this->params->get($key);
    }

    public function getMethod(): string
    {
        return $this->method;
    }

    public function getHost(): string
    {
        return $this->host;
    }

    public function getPort(): string
    {
        return $this->port;
    }

    public function getRoute(): string
    {
        return $this->route;
    }

    public function getAuthorization()
    {
        return $this->authorization;
    }
}