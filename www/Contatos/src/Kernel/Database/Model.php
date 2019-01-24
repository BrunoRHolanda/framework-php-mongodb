<?php

/**
 * @author Bruno R. Holanda <bruno@engtecnologia.com>
 * 
 * @license MIT.
 * 
 * Devido a Alta complexidade do trabalho com o driver do mongo de forma a 
 * mantar o código mais reutilisável porssível e dentro do padrão MVC foi 
 * nescessário a criação dessa classe de trabalho para realizar o mapeamento ODM.
 * 
 */
namespace App\Kernel\Database;

use MongoDB\BSON\Persistable;
use MongoDB\BSON\ObjectId;
use App\Kernel\Database\DB;
use App\Kernel\Support\Collection;
use App\Kernel\Database\Filter\Builder;

/**
 * Classe Model, tem o objetivo de fornecer um mapeamento ODM para o mongoDB, 
 * implementa a interface Persistable que permite essa classe ser passada como 
 * parâmetro nativo das funções de CRUD do Driver do mongoDB.
 *
*/
class Model implements Persistable
{

    /**
     * Por padrão pega o nome da classe como nome da coleção.
     * 
     */
    protected static $collection = __class__;

    /**
     * Chave primária padrão.
     * 
     */
    protected static $primaryKey = '_id';

    /**
     * campos que devem ser ocultos no retorno do método toArray().
     * 
     */
    protected static $hidden = ['__pclass'];

    /**
     * Verefica se o objeto foi alterado.
     * 
     */
    protected $altered = false;

    /**
     * Flags para otimizar a consulta no banco de dados.
     * 
     */
    protected $options = [];

    /**
     * Filtra as informações buscadas no banco de dados.
     * 
     */
    protected static $filter = [];

    /**
     * vetor de atributos da coleção.
     * 
     */
    protected $atributes = [];

    /**
     * Sobreescreve o método mágico mágico __get() para pegar um elemento do array de atributos.
     * 
     */
    public function __get($atribute)
    {
        return $this->atributes[$atribute];
    }

    /**
     * Sobreescreve o método mágico __set() para inserir um valor em um atributo.
     * 
     */
    public function __set($atribute, $value)
    {
        if (!isset($this->atributes[$atribute])) 
        {
            $this->altered = true;
            $this->atributes[$atribute] = $value;
        }
        else if ($this->atributes[$atribute] != $value) 
        {
            $this->altered = true;
            $this->atributes[$atribute] = $value;
        }
    }

    /**
     * Cria uma instância em um contexto estático do modelo, tem o mesmo efeito de new ClasseFilho().
     * 
     */
    public static function create(array $atributes)
    {
        
        $instance = new static();

        $instance->atributes = $atributes;

        return $instance;
    }

    /**
     * Gera o array que representa o objeto para ser salvo no banco.
     * 
     */
    public function bsonSerialize()
    {
        $this->atributes[self::getPrimaryKey()] = new ObjectId();

        if (isset($this->timestamps)) 
        {
            $this->createTimestamps();

            $this->atributes = array_merge($this->atributes, $this->timestamps);
        }

        return $this->atributes;
    }

    /**
     * Pega o array retornado pelo banco e salvo no vetor de atributos.
     * 
     */
    public function bsonUnserialize(array $data)
    {
        foreach ($data as $key => $value) 
        {
            $this->$key = $value;
        }
    }

    /**
     * Retorna uma representação de vetor dos atributos.
     * 
     */
    public function toArray(): array
    {
        $map =  $this->atributes;

        $hidden = self::getHidden();

        foreach ($this->atributes as $key => $value) 
        {
            if (array_search($key, $hidden) !== false)
            {
                unset($map[$key]);
            }
        }

        return $map;
    }

    /**
     * Salva o objeto em um documento no banco de dados.
     * 
     */
    public function save($options = [])
    {
        $collection = DB::get(self::getCollection());

        $primaryKey = self::getPrimaryKey();

        $this->options = array_merge($this->options, $options);

        if (!isset($this->atributes[$primaryKey]))
        {
            $collection->insertOne($this, $this->options);
        }
        else if ($this->altered === true)
        {
            $filter = Builder::filter([
                $primaryKey => $this->atributes[$primaryKey]
            ]);

            $collection->updateOne($filter, $this, $this->options);
        }

        return $this;
    }

    /**
     * Encontra um documento que corresponde ao id passado.
     * 
     */
    public static function find(string $id, $options = [])
    {
        $collection = DB::get(self::getCollection());

        $primaryKey = self::getPrimaryKey();

        $filter = Builder::filter([
            $primaryKey => new ObjectId($id)
        ]);

        $model = $collection->findOne($filter, $options);

        return $model;
    }

    /**
     * Lista todos os documentos que correspondem al $filter passado,
     * se nada for informado retorna todos os documentos.
     * 
     */
    public static function list(array $filter = [], $options = []): Collection
    {
        $collection = DB::get(self::getCollection());

        $cursor = $collection->find($filter, $options);

        return new Collection($cursor->toArray());
    }

    /**
     * Retorna a colleção usada nas operações.
     * 
     */
    public static function getCollection() 
    {
        $model = new static();

        return $model::$collection ?? self::$collection;
    }

    /**
     * Retorna a referência para a chave primária da coleção.
     * 
     */
    public static function getPrimaryKey()
    {
        $model = new static();

        return $model::$primaryKey ?? self::$primaryKey;
    }

    /**
     * Retorna os campos que devem ser ocultos.
     * 
     */
    public static function getHidden()
    {
        $model = new static();

        $hidden = self::$hidden;

        if (isset($model::$hidden))
        {
            $hidden = array_merge($hidden, $model::$hidden);
        }

        return $hidden;
    }
}
