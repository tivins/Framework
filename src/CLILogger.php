<?php

namespace Tivins\Framework;

class CLILogger extends Logger
{
    protected function render(string $type, string $msg, string $data = '') : void
    {
        echo date('c') . " [" . $this->typeToString($type) . "] $msg\n";
        if ($data) {
            echo "\t$data\n";
        }
    }
}
