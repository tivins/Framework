<?php

namespace Tivins\Framework;

class JSONDocument extends Document
{
    protected mixed $data;

    public function __construct()
    {
    }

    public function __toString() : string
    {
        return json_encode($this->data);
    }

    protected function overrideContentStatus(HTTPStatus $status, string $msg = '')
    {
    }

    public function deliver(HTTPStatus $status = HTTPStatus::OK)
    {
        if ($status->isError()) { /** @todo remove this? */
            $this->overrideContentStatus($status); /** @todo remove this? */
        }
        $contentInfo = new ContentInfo(ContentType::JSON, Charset::UTF8, $status);
        $http = new HTTP($contentInfo);
        $http->deliver($this);
    }
}