<?php

namespace Tivins\Framework;

class Enum
{
    private static $_names;

    protected static function remap()
    {
        $oClass = new \ReflectionClass(get_called_class());
        $consts = $oClass->getConstants();
        self::$_names = array_flip($consts);
    }

    public static function toString(int $state) : string
    {
        if (!isset(self::$_names)) self::remap();
        return self::$_names[$state] ?? (string) $state;
    }
}