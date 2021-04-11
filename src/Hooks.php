<?php

namespace Tivins\Framework;

class Hooks
{
    private static array $hooks = [];

    public static function register($name, Callable $callback)
    {
        self::$hooks[$name][] = $callback;
    }
    public static function run($name, &$variables)
    {
        if (! isset(self::$hooks[$name])) return;
        foreach (self::$hooks[$name] as $hook) {
            $hook($variables);
        }
    }
}