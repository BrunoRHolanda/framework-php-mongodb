<?php

namespace App\Kernel\Database\Filter\Operators;

class Exp
{
    /**
     * Operador igual á
     * 
     * Descrição: Corresponde a documentos que o valor de um campo é 
     * igual ao valor especificado.
     * 
     * Simbolo: '=='
     * 
     */
    public static $EQ = '$eq';

    /**
     * Operador maior que
     * 
     * Descrição: Corresponde a documentos que o valor de um campo é 
     * maior que ao valor específicado.
     * 
     * Simbolo: '>'
     * 
     */
    public static $GT = '$gt';

    /**
     * Operador maior e igual que
     * 
     * Descrição: Corresponde a documentos que o valor de um campo é 
     * maior e igual que ao valor específicado.
     * 
     * Simbolo: '>='
     * 
     */
    public static $GTE = '$gte';

    /**
     * Operador maior e igual que
     * 
     * Descrição: Corresponde a documentos que o valor de um campo é 
     * igual a qualquer valor dentro da matriz espacíficada.
     * 
     * Simbolo: '>='
     * 
     */
    public static $IN = '$in';

    /**
     * Operador menor que
     * 
     * Descrição: Corresponde a documentos que o valor de um campo é 
     * menor que ao valor específicado.
     * 
     * Simbolo: '<'
     * 
     */
    public static $LT = '$lt';

    /**
     * Operador menor e igual que
     * 
     * Descrição: Corresponde a documentos que o valor de um campo é 
     * menor e igual que ao valor específicado.
     * 
     * Simbolo: '<='
     * 
     */
    public static $LTE = '$lte';

    /**
     * Operador diferente de
     * 
     * Descrição: Corresponde a documentos que o valor de um campo não é 
     * igual que ao valor específicado.
     * 
     * Simbolo: '!='
     * 
     */
    public static $NE = '$ne';

    /**
     * Operador diferente em
     * 
     * Descrição: Corresponde a documentos que o valor de um campo não é 
     * igual ao vetor espefíficado ou o campo não exite.
     * 
     * Simbolo: '!='
     * 
     */
    public static $NIN = '$nin';

    /**
     * Operador lógico e
     * 
     * Descrição: Seleciona todos os documentos que satisfazem as 
     * expressões na matriz.
     * 
     * Simbolo: '&&'
     * 
     */
    public static $AND = '$and';

    /**
     * Operador lógico ou
     * 
     * Descrição: Seleciona os documentos que satisfazem pelo menos 
     * uma expressão na matriz.
     * 
     * Simbolo: '||'
     * 
     */
    public static $OR = '$or';

    /**
     * Operador lógico não
     * 
     * Descrição: Seleciona os documentos que não correspondem 
     * a expressão.
     * 
     * Simbolo: '!'
     * 
     */
    public static $NOT = '$not';

    /**
     * Operador lógico nem
     * 
     * Descrição: Seleciona todos os documentos que falham em 
     * todas as expressões de consulta.
     * 
     * Simbolo: 'nor'
     * 
     */
    public static $NOR = '$nor';
}