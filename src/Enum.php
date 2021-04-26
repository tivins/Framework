<?php
/**
* @example
* <code>
* use Tivins\Framework\Enum;
* class MyEnum extends Enum
* {
*    const CONST_1 = 1;
*    const CONST_2 = 2;
* }
* var_export(MyEnum::CONST_1); // 1
* var_export(MyEnum::toString(MyEnum::CONST_1)); // 'CONST_1'
* </code>
*/
namespace Tivins\Framework;

class Enum
{
    private static array $_names;

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