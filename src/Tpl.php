<?php

namespace Tivins\Framework;

/**
 * Simple Template Helper
 *
 *
 * Replacements :
 *
 * * {{variable}} : HTML entities processed (safest)
 * * {!variable!} : No process.
 *
 */
class Tpl
{
    public $html = '';
    public $vars = [];

    public function concat(string $html): void
    {
        $this->html .= $html;
    }

    public function setVar(string $key, string $value): void
    {
        $this->vars[$key] = $value;
    }

    public function setVars(array $keys_values): void
    {
        $this->vars[$key] += $keys_values;
    }

    public function render()
    {
        return $this->process($this->html, $this->vars);
    }

    public function process(string $str, array $vars): string
    {
        $str = preg_replace_callback('~{{(.*)}}~U',
            fn($matches) => html($vars[$matches[1]] ?? $matches[1]),
            $str);

        $str = preg_replace_callback('~{!(.*)!}~U',
            fn($matches) => ($vars[$matches[1]] ?? $matches[1]),
            $str);

        return $str;
    }

}
