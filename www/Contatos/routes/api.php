<?php

return [

    /**
     * Rota default
     *
     */
    '/index' => [

        'controller' => 'IndexController',
        'action' => 'index',
        'method' => 'GET',
        'auth' => false,
    ],

    '/contato/add' => [

        'controller' => 'ContatosController',
        'action' => 'store',
        'method' => 'GET',
        'auth' => false,
    ],

    '/contato/:id' => [

        'controller' => 'ContatosController',
        'action' => 'find',
        'method' => 'GET',
        'auth' => false,
        'params' => [

            'id' => 'string',
        ]
    ],

    '/contato/por/idade/:idade' => [

        'controller' => 'ContatosController',
        'action' => 'listarPorIdade',
        'method' => 'GET',
        'auth' => false,
        'params' => [

            'idade' => 'number',
        ]
    ],

    '/contatos/all' => [

        'controller' => 'ContatosController',
        'action' => 'all',
        'method' => 'GET',
        'auth' => false
    ],
];