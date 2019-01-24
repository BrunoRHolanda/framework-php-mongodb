<?php

namespace App\Kernel\Support;

use App\Kernel\Http\Request;

class Authenticator
{
    private $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function authenticateUser(): bool
    {
        return true;
    }
}