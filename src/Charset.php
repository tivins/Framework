<?php

namespace Tivins\Framework;

enum Charset: string
{
    case ASCII = "";
    case UTF8 = "utf-8";

    public function toString(): string
    {
        return $this->value;
    }
}
