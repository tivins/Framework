<?php
namespace Tivins\Framework;

class Singleton
{
    private static $instance;

    public static function getInstance()
    {
        if (! isset($instance)) {
            $class = get_called_class();
            self::$instance = new $class;
        }
        return self::$instance;
    }

    protected function __construct()
    {
    }
}
