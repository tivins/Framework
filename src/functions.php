<?php

function html(string $s)
{
    return htmlspecialchars($s);
}

function redirect(string $url)
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
