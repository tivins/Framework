<?php

namespace Tivins\Framework;

class ContentInfo
{
    public string $type;
    public string $charset;
    public int    $status;

    public function __construct(
        string $type    = ContentType::Text,
        string $charset = Charset::ASCII,
        int    $status  = HTTPStatus::OK,
    )
    {
        $this->type     = $type;
        $this->charset  = $charset;
        $this->status   = $status;
    }
}
