<?php

namespace Tivins\Framework;

class Cache
{
    const INFINITE = -1;

    private static $path = '/tmp';
    private static $cacheTime = 3600;

    /**
     *
     */
    public static function load(string $url, $cURL = null): string
    {
        $hash = self::$path . '/' . sha1($url);
        if
        (
            file_exists($hash) &&
            (self::$cacheTime == self::INFINITE || filemtime($hash) > time() - self::$cacheTime)
        )
        {
            return file_get_contents($hash);
        }
        if ($cURL) { $content = curl_exec($cURL); }
        else { $content = file_get_contents($url); }
        file_put_contents($hash, $content);
        return (string) $content;
    }

    /**
     * @see self::INFINITE
     */
    public static function setExpiration(int $seconds) : void
    {
        self::$cacheTime = $seconds;
    }

    public static function setPath(string $path) : void
    {
        self::$path = $path;
    }
}