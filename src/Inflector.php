<?php

namespace DietCook;

class Inflector
{
    public static function camelize(string $str): string
    {
        return str_replace(' ', '', ucwords(str_replace('_', ' ', $str)));
    }

    public static function underscore(string $str): string
    {
        /* [A-Z]+ と [A-Z][a-z]* を単語とみなす。
         * つまり、単語の境界は
         *     [a-z][A-Z]
         *          ^ココ
         * または
         *     [A-Z][A-Z][a-z]
         *          ^ココ
         * となる。
         */
        return strtolower(preg_replace('/([a-z]+(?=[A-Z])|[A-Z]+(?=[A-Z][a-z]))/', '\\1_', $str));
    }
}
