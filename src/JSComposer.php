<?php

namespace Tivins\Framework;

class JSComposer
{
    private string $source = '';

    public function __construct()
    {

    }

    public function add(string $script)
    {
        $this->source .= IO::download(__dir__ . '/../js/' . $script);
    }

    public function getSource(): string
    {
        return $this->source;
    }
}