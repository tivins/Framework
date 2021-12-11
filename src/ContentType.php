<?php

namespace Tivins\Framework;

enum ContentType: String
{
    case TEXT = "text/plain";
    case HTML = "text/html";
    case CSS = "text/css";
    case JS = "text/javascript";
    case PNG  = "image/png";
    case JPEG = "image/jpeg";
    case JSON = "application/json";

    public function toString(): string
    {
        return $this->value;
    }
}
