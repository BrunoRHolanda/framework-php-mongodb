<?php

namespace App\Controllers;

use MongoDB\BSON\ObjectId;
use App\Kernel\Database\DB;
use App\Kernel\Http\Request;
use App\Kernel\Http\Response;
use App\Kernel\Support\Collection;
use App\Models\Pessoa;

class ContatosController
{
    private $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function store()
    {

    }

    public function find($id)
    {
        $pessoa = Pessoa::find($id);

        return Response::json($pessoa->toArray());
    }

    public function all()
    {
        $pessoas = Pessoa::list();

        return Response::json($pessoas->toArray());
    }

    public function listarPorIdade($idade)
    {
        $pessoas = Pessoa::listarPorIdade((int) $idade);

        return Response::json($pessoas->toArray());
    }
}