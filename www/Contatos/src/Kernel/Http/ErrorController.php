<?php

namespace App\Kernel\Http;

use App\Kernel\Http\Request;
use App\Kernel\Http\Response;

class ErrorController
{
    public function __construct(Request $request)
    {
        
    }

    public function notFound(): Response
    {
        return Response::json([
            "error" => "controller not found"
        ], 404);
    }
}