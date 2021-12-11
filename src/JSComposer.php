<?php

namespace Tivins\Framework;

class JSComposer
{
    private array  $scripts = [];

    public function __construct()
    {

    }

    public function add(string $script)
    {
        $this->scripts[] = $script;
    }

    public function __toString(): string
    {
        $main = '(function(){';
        $source = '';
        foreach ($this->scripts as $script) {
            $source .= IO::download(__dir__ . '/../js/' . $script);
            $main .= basename($script,'.js').'();';
        }
        $main .= '})();';
        return $source.$main;
    }
}