<?php

namespace Tivins\Framework;

class Framework
{
    public static function init()
    {
        set_error_handler(function($errno,$errstr,$file,$line) {

            echo "
                <h1>Error: $errno</h1>
                <p>$errstr</p>
                <div>$file<br>line $line</div>
            ";
            die;
        });
    }
}