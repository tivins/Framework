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
        $time = microtime(true);
        $orglen = strlen($this->source);
        $this->source = preg_replace_callback('~#mixin(.*)\{([^\}]*?)\}~sU', function ($matches) {
            $ruleName = trim($matches[1], "\t\r\n\v. ");
            $cssRule = trim($matches[2]);
            $this->mixins[$ruleName] = $cssRule;
            return '';
        }, $this->source);

        $this->source = preg_replace_callback('~mx\(([\w\-]+)\)~', function ($matches) {
            return $this->mixins[$matches[1]];
        }, $this->source);
        $this->source = preg_replace_callback('~@mixin\s+([\w\-]+)~', function ($matches) {
            return $this->mixins[$matches[1]];
        }, $this->source);

        $expandedLen = strlen($this->source);
        $this->compact();
        $newlen = strlen($this->source);

        $prog = $newlen/$expandedLen*100;
        $duration = round((microtime(true) - $time)*1000, 2);
        $date = date('c');
        $compress = round(100-$prog, 1);
        return "/*\n\ttivins/framework\n\tgenerated @ {$date} in {$duration}ms\n"
            . "\tSource: {$orglen}\n"
            . "\tExpanded: {$expandedLen}\n"
            . "\tCompressed: {$newlen} (-{$compress}%)\n"
            . "*/\n"
            . $this->source;
    }

    protected function compact()
    {
        $this->source = preg_replace('~(\S)(\s+);~', '$1;', $this->source);
        $this->source = preg_replace('~(\})\s+~', '$1'."\n", $this->source);
        $this->source = preg_replace('~/\*(.*)\*/~', ''."\n", $this->source);
        $this->source = preg_replace('~/\*(.*)\*/~s', '', $this->source);
        $this->source = preg_replace('~^\s*$~m', '', $this->source);
        $this->source = preg_replace('~^\s*~m', '', $this->source);/*all to the left*/
        $this->source = preg_replace_callback('~\{\s*(.*?)\s*\}~s', fn($matches) => '{'.trim(str_replace("\n"," ", $matches[1])).'}', $this->source);
        $this->source = preg_replace('~(\w):\s+~', '$1:', $this->source);
        $this->source = preg_replace('~(\w)\s+\{~', '$1{', $this->source);
        $this->source = preg_replace('~;\s*\}~', '}', $this->source);/*remove unnecessary last semi-colon*/
        $this->source = preg_replace('~;\s*(\w)~', ';$1', $this->source);/*remove unnecessary last semi-colon*/
        // $this->source = preg_replace('~\n~m', '', $this->source);
    }
}