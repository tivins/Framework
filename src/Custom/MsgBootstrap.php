<?php

namespace Tivins\Framework\Custom;

use Tivins\Framework\Msg;

class MsgBootstrap extends Msg
{
    protected function wrap(string $html) : string
    {
        return '<div class="my-3">' . $html . '</div>';
    }

    protected function render(array $msgData) : string
    {
        $class = $msgData[1];
        if ($class == 'error') $class = 'danger';
        return '<div class="alert alert-' . $class . '">' . $msgData[0] . '</div>';
    }
}
