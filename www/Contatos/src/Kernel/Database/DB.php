<?php

namespace App\Kernel\Database;

use App\Kernel\Helpper\Config;
use MongoDB\Client as MongoDB;

class DB
{
    public static function get( $collection )
    {
        $configuration = Config::getInstance()->getConfiguation()['db'];

        $database = $configuration['mongodb']['db'];

        return (new MongoDB())->$database->$collection;
    }
}