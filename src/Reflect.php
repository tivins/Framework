<?php
namespace Tivins\Framework;

use ReflectionClass;

class Reflect
{
    public static function getConstants($cn)
    {
        static $cache;
        if (!isset($cache)) {
            $reflect = new ReflectionClass($cn);
            $cache = $reflect->getConstants();
        }
        return $cache;
    }
}
