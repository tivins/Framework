<?php

namespace Tivins\Framework;

class ContentInfo
{
    public function __construct(
        public ContentType $type = ContentType::TEXT,
        public Charset     $charset = Charset::ASCII,
        public HTTPStatus  $status = HTTPStatus::OK,
    )
    {
    }
    public function buildString(): string
    {
        $ct = $this->type->toString();
        if ($cs = $this->charset) {
            $ct .= "; charset={$cs->value}";
        }
        return $ct;
    }

}
