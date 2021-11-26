<?php

namespace Tivins\Framework;
/**
 *
 * Ex:
 *
 * $http->deliver($doc->getContentInfo(), $doc);
 * (new HTTP(new ContentInfo(ContentType::PNG)))->deliver($imagickObject);
 */
class HTTP
{
    private ContentInfo $contentInfo;

    public function __construct(ContentInfo $contentInfo)
    {
        $this->contentInfo = $contentInfo;
    }

    public function deliver(string $contentBody)/*: never */
    {
        http_response_code($this->contentInfo->status);
        header("Content-Type: " . $this->buildContentTypeString());
        echo $contentBody;
        exit(0);
    }

    private function buildContentTypeString(): string
    {
        $ct = $this->contentInfo->type;
        if ($cs = $this->contentInfo->charset) {
            $ct .= "; charset={$cs}";
        }
        return $ct;
    }
}
