<?php

namespace Tivins\Framework;

class JSONDocument extends Document
{
    private $data;

    public function __construct()
    {
    }

    public function __toString() : string
    {
        return json_encode($this->data);
    }

    public function deliver(int $status = HTTPStatus::OK)
    {
        if (HTTPStatus::isError($status)) {
            $this->overrideContentStatus($status);
        }
        $contentInfo = new ContentInfo(ContentType::JSON, Charset::UTF8, $status);
        $http = new HTTP($contentInfo);
        $http->deliver($this);
    }
}