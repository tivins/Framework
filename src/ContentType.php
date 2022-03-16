<?php

namespace Tivins\Framework;

enum ContentType: string
{
    case NONE = "";
    case ALL  = "*";

    case TEXT = "text/plain";
    case HTML = "text/html";
    case CSS  = "text/css";
    case JS   = "text/javascript";

    case PNG  = "image/png";
    case JPEG = "image/jpeg";

    case JSON = "application/json";
}
