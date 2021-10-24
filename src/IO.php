<?php

/**
 *
 */
namespace Tivins\Framework;

class URI {

    public static function getScheme(string $uri): ?string
    {
        $found = (bool) preg_match('~^([a-z]+)://~', $uri, $matches);
        return $found ? $matches[1] : null;
    }
}

/**
 *
 */
class IO
{
    /**
     *
     */
    public static function download(string $url): ?string
    {
        error_log("IO::download('$url').");

        $output = null;
        $hasScheme = URI::getScheme($url);
        if ($hasScheme && function_exists('curl_init'))
        {
            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_HEADER, false);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
            curl_setopt($ch, CURLOPT_MAXREDIRS, 10);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 4);
            curl_setopt($ch, CURLOPT_TIMEOUT, 8);
            $result = curl_exec($ch);
            $info   = curl_getinfo($ch);

            // We wont get 404 content
            if ($result !== false && $info['http_code'] != 200) {
                $output = $result;
            }
        }
        else {
            $result = file_get_contents($url);
            if ($result !== false) {
                $output = $result;
            }
        }
        return $output;
    }

    /**
     *
     */
    public static function cache_cache(string $url, string $fname, int $cache_time = 0): ?string
    {
        if (file_exists($fname) && filemtime($fname) > time() - $cache_time)
        {
            $data = file_get_contents($fname);
        }
        else
        {
            error_log("cache_cache(): reload '$url'.");
            $data = IO::download($url);
            if (self::mkdirfile($fname)) {
                file_put_contents($fname, $data);
            }
        }
        return $data !== false ? $data : null;
    }

    /**
     *
     */
    public static function mkdirfile(string $filename): bool
    {
        error_log("IO::mkdirfile('$filename').");
        $dir = dirname($filename);
        if (! is_dir($dir)) {
            mkdir($dir, 0755, true);
        }
        return is_dir($dir);
    }
}
