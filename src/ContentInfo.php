<?php

namespace Tivins\Framework;

class ContentInfo
{
    public string $type;
    public string $charset;

    public function __construct(
        string $type    = ContentType::Text,
        string $charset = Charset::ASCII
    )
    {
        $this->type = $type;
        $this->charset = $charset;
    }
}
