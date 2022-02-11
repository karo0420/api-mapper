<?php

namespace Karo0420\ApiMapper;

class ApiMapper
{
    public static function make(string $from)
    {
        return new $from(new Loader());
    }
}