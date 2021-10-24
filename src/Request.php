<?php

namespace Tivins\Framework;

class Request
{
    private int $time = 0;

    public function __construct()
    {
        $this->time = $_SERVER['REQUEST_TIME'] ?? time();

        if (self::isCLI())
        {
            global $argv;
            if (!isset($argv[1])) { die("Arg1 must be HTTP_HOST.\n"); }
            if (!isset($argv[2])) { die("Arg2 must be REQUEST_URI.\n"); }
            $_SERVER['HTTP_HOST']      = $argv[1];
            $_SERVER['REQUEST_URI']    = $argv[2];
            $_SERVER['REMOTE_ADDR']    = '::1';
            $_SERVER['REQUEST_SCHEME'] = 'php' . PHP_VERSION_ID;
        }

    }

    public static function isCLI(): bool
    {
        return PHP_SAPI == "cli";
    }

    public function getTime(): int
    {
        return $this->time;
    }

    public function getLanguages()
    {
        return self::parseQualityValues($_SERVER['HTTP_ACCEPT_LANGUAGE'] ?? '');
    }

    public function getPreferedLanguage()
    {
        return key($this->getLanguages());
    }

    public function getRequestURI(): string
    {
        return ltrim($_SERVER['REQUEST_URI'], '/') ?? '';
    }

    // --

    public static function parseQualityValues($string)
    {
        $output = [];
        $data = explode(',', $string);
        foreach ($data as $qValue) {
            [$value, $factor] = explode(';', $qValue) + ['', 'q=1'];
            $factor = (float) substr($factor, 2); // remove 'q='
            $output[$value] = $factor;
        }
        arsort($output);
        return $output;
    }

}