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

    /**
     * Gets the timestamp of the request.
     */
    public function getTime(): int
    {
        return $this->time;
    }

    public function getLanguages(): array
    {
        return self::parseQualityValues($_SERVER['HTTP_ACCEPT_LANGUAGE'] ?? '');
    }

    public function getPreferedLanguage(): ?string
    {
        $langs = $this->getLanguages();
        if (is_empty($langs)) {
            return null;
        }
        return array_key_first($langs);
    }

    public function getRequestURI(): string
    {
        [$uri] = explode('?', ltrim($_SERVER['REQUEST_URI'] ?? '', '/'));
        return $uri;
    }

    // -- Static functions --

    /**
     * Returns if the SAPI is cli or not.
     */
    public static function isCLI(): bool
    {
        return PHP_SAPI == "cli";
    }

    /**
     * Gets a sorted associative array as :
     *
     *     [ name1 => factor1, name2 => factor2, ... ]
     *
     * @see https://developer.mozilla.org/en-US/docs/Glossary/Quality_values
     */
    public static function parseQualityValues(string $qValuesStr): array
    {
        $output = [];
        $qValues = explode(',', $qValuesStr);
        foreach ($qValues as $qValue)
        {
            [$value, $factor] = explode(';', $qValue) + ['', 'q=1'];
            $factor = (float) substr($factor, 2); // remove 'q='
            $output[$value] = $factor;
        }
        arsort($output);
        return $output;
    }

}
