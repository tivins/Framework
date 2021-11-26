<?php

namespace Tivins\Framework;

class ContentInfo
{
    public function __construct(
        public string $type    = ContentType::Text,
        public string $charset = Charset::ASCII,
        public int    $status  = HTTPStatus::OK,
    )
    {
        $this->type     = $type;
        $this->charset  = $charset;
        $this->status   = $status;
    }
}
