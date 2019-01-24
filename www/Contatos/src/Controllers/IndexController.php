<?php

namespace App\Controllers;

use App\Kernel\Http\Request;
use App\Kernel\Http\Response;

class IndexController
{
    private $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function index()
    {
        return Response::json([
            'status' => 'You Connected in API - ENG 1.0'
        ]);
    }
}