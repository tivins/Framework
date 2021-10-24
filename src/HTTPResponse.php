<?php

namespace Tivins\Framework;

class HTTPResponse
{
    public function render(HTMLDocument $htmldoc)
    {
        header("Content-Type: text/html; charset=utf-8");
        echo $htmldoc->render();
        exit(0);
    }
}