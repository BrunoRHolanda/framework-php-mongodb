<?php

namespace App\Kernel\Database;

use MongoDB\BSON\UTCDateTime;

trait Timestamps
{
    public $timestamps = [];

    public function createTimestamps()
    {
        $this->timestamps = [
            'createdAt' => new UTCDateTime(),
            'uploadedAt' => null,
        ];
    }

    public function uploadTimestamp()
    {
        $this->timestamps['uploadedAt'] =  new UTCDateTime();
    }
}
