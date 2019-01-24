<?php

namespace App\Kernel;

use App\Kernel\Helpper\Config;
use App\Kernel\Http\Request;
use App\Kernel\Http\Response;
use App\Kernel\Helpper\Router;

class App 
{
    private $configuration;

    private function __construct(Config $configuration) 
    {
        $this->configuration = $configuration;
    }

    public static function make(Config $configuration) 
    {
        return new App($configuration);
    }

    public function handle(Request $request): Response
    {
        return (
            new Router($this->configuration->getConfiguation()["routes"])
        )->route($request);
    }
}