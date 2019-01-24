<?php

namespace App\Kernel\Helpper;

class Config 
{
    private static $instance;

    private $config;

    private $routes;

    private function __construct($config, $routes) 
    {
        $this->config = $config;
        $this->routes = $routes;
    }

    public static function getInstance($config = [], $routes = []): Config
    {
        if (!isset(self::$instance))
        {
            self::$instance = new Config($config, $routes);
        }

        return self::$instance;
    }

    public function getConfiguation(): Array
    {
        return [ 
            "db" => $this->config,
            "routes" => $this->routes
        ];
    }
}