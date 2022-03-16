<?php

namespace Tivins\Framework;

use Tivins\Core\Http\Method as HTTPMethod;

class Request
{
    private int $time;
    private ?HTTPMethod $method;

    public function __construct()
    {
        /**
         * @todo Use WebEngine::Boot instead (futurs commits)
         */
        if (self::isCLI())
        {
            global $argv;

            if (!isset($argv[1])) { die("Arg1 must be HTTP_HOST.\n"); }
            if (!isset($argv[2])) { die("Arg2 must be REQUEST_URI.\n"); }
            $_SERVER['HTTP_HOST']      = $argv[1];
            $_SERVER['REQUEST_URI']    = $argv[2];

            /** @noinspection SpellCheckingInspection */
            $_SERVER['REMOTE_ADDR']    = 'cli';
            $_SERVER['REQUEST_SCHEME'] = 'php' . PHP_VERSION_ID;
            $_SERVER['REQUEST_METHOD'] = '';
            $_SERVER['HTTP_ACCEPT']    = 'text/plain';
        }
        $this->time   = $_SERVER['REQUEST_TIME'] ?? time();
        $this->method = HTTPMethod::tryFrom($_SERVER['REQUEST_METHOD']);
    }

    public function getHost(): string
    {
        return $_SERVER['HTTP_HOST'];
    }

    /**
     * Gets the timestamp of the request.
     */
    public function getTime(): int
    {
        return $this->time;
    }

    /**
     * Gets the HTTP Method of the request.
     */
    public function getMethod(): HTTPMethod
    {
        return $this->method;
    }

    public function getAccept(): array
    {
        return self::parseQualityValues($_SERVER['HTTP_ACCEPT'] ?? '');
    }

    public function getPrimaryAccept(): ContentType
    {
        $accepts = $this->getAccept();
        return ContentType::tryFrom(array_key_first($accepts)) ?? ContentType::NONE;
    }

    public function getLanguages(): array
    {
        return self::parseQualityValues($_SERVER['HTTP_ACCEPT_LANGUAGE'] ?? '');
    }

    public function getPreferredLanguage(): string
    {
        return key($this->getLanguages());
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
            $output[trim($value)] = $factor;
        }
        arsort($output);
        return $output;
    }

}