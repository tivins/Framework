<?php

namespace Tivins\Framework;

class CSSMixins
{
    public string $source;
    public array $mixins = [];
    public function __construct(string $source)
    {
        $this->source = $source;
    }

    public function __toString(): string
    {
        $this->source = preg_replace_callback('~#mixin(.*)\{([^\}]*?)\}~sU', function ($matches) {
            $ruleName = trim($matches[1], "\t\r\n\v. ");
            $cssRule = trim($matches[2]);
            $this->mixins[$ruleName] = $cssRule;
            return '';
        }, $this->source);

        $this->source = preg_replace_callback('~@mixin\s+([\w\-]+);~', function ($matches) {
            return $this->mixins[$matches[1]];
        }, $this->source);

        return '/* generated @ '.date('c').' */'. "\n" . $this->source;
    }
}