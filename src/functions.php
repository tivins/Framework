<?php

/**
 * @todo Move into an (string)Util class
 */
function html(string $s): string
{
    return htmlspecialchars($s);
}

/**
 * @todo Move ?
 */
function redirect(string $url)/*: never*/
{
    header('Location: ' . $url);
    exit;
}

/**
 * Replace in $sources all occurence of keys in $replacements by associated
 * values of $replacements.
 */
function replaceArray(string $source, array $replacements): string
{
    return str_replace(
        array_keys($replacements),
        array_values($replacements),
        $source);
}

/**
 * @deprecated
 * @todo remove now ?
 */
function getPath(int $index, string $default = '')
{
    static $path;
    if (!isset($path)) $path = explode('/', $_GET['q'] ?? '');
    return $path[$index] ?? $default;
}

function mapHTMLTag(string $model, array $stringList): string
{
    return join('', array_map(
        fn($value) => str_replace('{{ value }}', $value, $model),
        $stringList)
    );
}

/* will be (re)moved soon */
function pathToURL($path) {
    /* TODO : add config path here */
    return "/$path";
}

/* will be (re)moved soon */
function assertAuth($redirectURL = 'user')
{
    if (Session::auth()) return;
    redirect(pathToURL($redirectURL));
}


function time_short(int $timestamp)
{
    return date('d M. Y', $timestamp);
}