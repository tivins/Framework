<?php

namespace Tivins\Framework;

class Msg
{
    const Error   = 'error';
    const Warning = 'warning';
    const Success = 'success';

    public static function push(string $msg, string $type) : void
    {
        $_SESSION['msg'][] = [$msg, $type];
    }

    public static function get() : string
    {
        if (empty($_SESSION['msg'])) return '';
        $msgs = $_SESSION['msg'] ?? [];
        $_SESSION['msg'] = [];
        return '<div class="alerts">'
            . implode(array_map(fn($msgData) => '<div class="alert ' . $msgData[1] . '">' . $msgData[0] . '</div>', $msgs))
            . '</div>';
    }
}

