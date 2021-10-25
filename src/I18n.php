<?php

namespace Tivins\Framework;

class I18n
{
    public static $data = [];

    public static function get($s)
    {
        return self::$data[$s] ?? $s;
    }

    public static function load(string $filename)
    {
        include $filename;
    }
}