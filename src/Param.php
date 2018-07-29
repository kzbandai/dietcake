<?php

namespace DietCook;

class Param
{
    public static function get(string $name, $default = null)
    {
        return $_REQUEST[$name] ?? $default;
    }

    public static function params()
    {
        return $_REQUEST;
    }
}
