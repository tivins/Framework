<?php
namespace Tivins\Framework;

class Singleton
{
    private static $instances = [];

    public static function &getInstance()
    {
        $class = get_called_class();
        if (empty(self::$instances[$class])) {
            self::$instances[$class] = new $class;
        }
        return self::$instances[$class];
    }

    protected function __construct() { }
    final private function __clone() { }
}
