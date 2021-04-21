<?php

namespace Tivins\Framework;

class Form
{
    public static function form(string $formId, string $formAction, string $formContent)
    {
        return '<form method="post" action="' . $formAction . '">'
            . self::hidden('hash', encode_security_token($formId))
            . $formContent
            . '</form>';
    }

    public static function hidden(string $name, string $value) : string
    {
        return '<input type="hidden" name="' . html($name) . '" value="' . html($value) . '">';
    }

    public static function select(string $name, array $options, array $selected) : string
    {
        $html = '<select name="' . $name . '">';
        foreach ($options as $key => $value) {
            $attrs = in_array($key, $selected) ? ' selected' : '';
            $html .= '<option value="' . html($key). '"' . $attrs . '>' . html($value) . '</option>';
        }
        $html .= '</select>';
        return $html;
    }
}

