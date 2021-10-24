<?php

namespace Tivins\Framework;
/**
 *
 * Ex:
 *
 * HTTP::deliver($doc->getContentInfo(), $doc);
 * HTTP::deliver(new ContentInfo(ContentType::PNG), $imagickObject);
 */
class HTTP
{
    private ContentInfo $contentInfo;

    public function __construct(ContentInfo $contentInfo)
    {
        $this->contentInfo = $contentInfo;
    }

    public function deliver(string $contentBody)/*:never*/
    {
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
