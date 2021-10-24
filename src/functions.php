<?php

function html(string $s): string
{
    return htmlspecialchars($s);
}

function redirect(string $url) // : never
{
    header('Location: ' . $url);
    exit;
}

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
