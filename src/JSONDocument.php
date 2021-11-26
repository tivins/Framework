<?php

namespace Tivins\Framework;

class JSONDocument extends Document
{
    protected $data;

    public function __construct()
    {
    }

    public function __toString() : string
    {
        return json_encode($this->data);
    }

    protected function overrideContentStatus(int $status, string $msg = '')
    {
    }

    public function deliver(int $status = HTTPStatus::OK)
    {
        if (HTTPStatus::isError($status)) { /** @todo remove this? */
            $this->overrideContentStatus($status); /** @todo remove this? */
        }
        $contentInfo = new ContentInfo(ContentType::JSON, Charset::UTF8, $status);
        $http = new HTTP($contentInfo);
        $http->deliver($this);
    }
}