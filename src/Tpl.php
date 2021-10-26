<?php

namespace Tivins\Framework;

/**
 * Simple Template Helper
 *
 * Replacements :
 *
 * * {{ variable }} : HTML entities processed.
 * * {! variable !} : No process.
 *
 * Usage :
 *
 * use Tivins\Framework\Tpl;
 * $tpl = new Tpl();
 * $tpl->load("page.html");
 * $tpl->setBody("<p>{{greetings}}</p>");
 * $tpl->setVar("greetings", "Hello & world");
 * echo $tpl; // `<p>Hello &amp; world</p>`
 *
 */
class Tpl
{
    public string $html = '';
    public array  $vars = [];

    public function __construct(string $fileOrContent)
    {
        if (file_exists($fileOrContent)) {
            $this->load($fileOrContent);
        } else {
            $this->setBody($fileOrContent);
        }
    }

    public function concat(string $html): void
    {
        $this->html .= $html;
    }

    public function setBody(string $body): void
    {
        $this->html = $body;
    }

    public function load(string $filename): bool
    {
        $data = IO::download($filename);
        if (is_null($data)) {
            return false;
        }
        $this->html = $data;
        return true;
    }

    public function setVar(string $key, string $value): void
    {
        $this->vars[$key] = $value;
    }

    public function setVars(array $keys_values): void
    {
        $this->vars += $keys_values;
    }

    public function process(string $str, array $vars): string
    {
        $str = preg_replace_callback('~{{\s?(.*)\s?}}~U',
            fn($matches) => html($vars[$matches[1]] ?? $matches[1]),
            $str);

        $str = preg_replace_callback('~{!\s?(.*)\s?!}~U',
            fn($matches) => ($vars[$matches[1]] ?? $matches[1]),
            $str);

        return $str;
    }

    public function __toString(): string
    {
        return $this->process($this->html, $this->vars);
    }

}
