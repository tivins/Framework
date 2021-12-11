<?php

namespace Tivins\Framework;
/**
 *
 * Ex:
 *
 * ```
 * (new HTTP(new ContentInfo(ContentType::PNG)))->deliver($imagickObject);
 * ```
 */
class HTTP
{
    private ContentInfo $contentInfo;

    public function __construct(ContentInfo $contentInfo)
    {
        $this->contentInfo = $contentInfo;
    }

    public function deliver(string $contentBody): never
    {
        http_response_code($this->contentInfo->status->toInteger());
        header("Content-Type: " . $this->buildContentTypeString());
        // header('Access-Control-Allow-Origin: *');
        echo $contentBody;
        exit(0);
    }

    private function buildContentTypeString(): string
    {
        $ct = $this->contentInfo->type->toString();
        if ($cs = $this->contentInfo->charset) {
            $ct .= "; charset={$cs->toString()}";
        }
        return $ct;
    }

    /**
     * @param mixed $data Something that can be encoded to JSON.
     * @param HTTPStatus $status The HTTP Status for the response.
     */
    public static function sendJSON(mixed $data, HTTPStatus $status = HTTPStatus::OK)
    {
        (new self(new ContentInfo(ContentType::JSON, Charset::UTF8, $status)))
        ->deliver(json_encode($data));
    }

    /**
     *
     */
    public static function sendJS(mixed $data, HTTPStatus $status = HTTPStatus::OK): never
    {
        (new self(new ContentInfo(ContentType::JS, Charset::UTF8,  $status)))
        ->deliver($data);
    }
}
