<?php

namespace Tivins\Framework;

class Boot
{
    public function __construct()
    {
        $this->registerHandlers();
    }

    private function registerHandlers()
    {
        set_exception_handler(function($ex)
        {
            header("Content-Type: text/html; charset=utf-8");
            echo '<!doctype html lang="en"><html lang="en"><head><title>Carnet</title></title><meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1"></head><body>';
            echo '<div style="max-width:800px;margin:auto"><h1>Sorry,</h1>';
            echo '<p>There were once was an internal server error...</p>';

            if (defined('FRAMEWORK_MODE') && FRAMEWORK_MODE == 'dev')
            {
                echo '<pre>' . $ex->getMessage() . '</pre>';
                echo "<h3>DEBUG INFORMATIONS</h3>";
                echo '<pre>' . print_r($ex, true) . '</pre>';
            }

            echo '<p>Maybe you can reach the <a href="/">home page</a> ?</p>
                </div></body></html>';
            exit;
        });
    }

}