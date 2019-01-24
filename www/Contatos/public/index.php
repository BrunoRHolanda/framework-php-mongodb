<?php

/**
 * Inicia as instâncias e dependências do app
 * 
 */
require __DIR__ . '/../vendor/autoload.php';

/**
 * Pega as configurações do App
 * 
 */
$dbConfig = require_once __DIR__ . '/../config/database.php';
$routes = require_once __DIR__ . '/../routes/api.php'; 

/**
 * Pega a instância das configurações
 * 
 */
$config = App\Kernel\Helpper\Config::getInstance($dbConfig, $routes);

/**
 * Cria o kernel de aplicação inicializando com as configurações
 * 
 */
$kernel = App\Kernel\App::make($config);

/**
 * Pega a requisição e trabalha na resposta para o cliente.
 *
 */
$response = $kernel->handle(
    App\Kernel\Http\Request::capture()
);

/**
 * Envia resposta ao cliente
 * 
 */
$response->send();
