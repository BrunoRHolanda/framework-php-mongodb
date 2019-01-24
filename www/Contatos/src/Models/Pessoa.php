<?php

namespace App\Models;

use App\Kernel\Database\Model;
use App\Kernel\Database\Timestamps;
use App\Kernel\Database\Filter\Builder;
use App\Kernel\Database\Filter\Operators\Exp;

class Pessoa extends Model
{
    /**
     * Adiciona os timestamps de controle de ciração e atualização do documento.
     * 
     */
    use Timestamps;

    /**
     * Informa a coleção alvo do modelo.
     * 
     */
    protected static $collection = 'Pessoas';

    /**
     * Campos que não irão aparecer quando a função toArray() for invocada.
     *
     */
    protected static $hidden = [
        'createdAt',
        'uploadedAt',
    ];

    public static function listarPorIdade(int $idade)
    {
        return self::list(Builder::filter([
            'idade' => $idade
        ]));
    }
}