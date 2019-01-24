<?php

namespace App\Kernel\Support;

class Collection 
{
    private $map;

    public function __construct(array $array)
    {
        $this->map = $array;
    }

    public function __get(string $atribute) 
    {
        $value = $this->map[$atribute] ?? null;

        if (gettype($value) == 'string') 
        {
            $value = addslashes($value);
        }

        return $value;
    }

    public function __set(string $atribute, $value)
    {
        if (gettype($value) == 'string') 
        {
            $value = addslashes($value);
        }

        $this->map[$atribute] = $value;
    }

    public function has(string $key): bool
    {
        return isset($this->map[$key]);
    }

    public function get(string $key, $default = null, $filter = true)
    {
        $value = $this->map[$key] ?? $default;

        if (gettype($value) == 'string' && $filter )
        {
            $value = addslashes($value);
        }

        return $value;
    }

    public function toArray(string $content = 'complex')
    {
        $map = [];

        if ($content == 'atomic')
        {
            $map = $this->map;
        } 
        else if ($content == 'complex')
        {
            foreach ($this->map as $key => $value)
            {
                $map[] = $value->toArray();
            }
        }

        return $map;
    }
}