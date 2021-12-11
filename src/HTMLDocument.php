<?php

namespace Tivins\Framework;

class HTMLDocument extends Document
{
    protected string $body         = '';
    protected array  $scripts      = [];
    protected array  $stylesheets  = [];

    public function __construct()
    {
    }

    public function addScripts(string ...$fileURL) : self
    {
        foreach ($fileURL as $url) {
            $this->scripts[] = $url;
        }
        return $this;
    }

    public function removeScripts() : self
    {
        $this->scripts = [];
        return $this;
    }

    public function addStylesheets(string ...$fileURL) : self
    {
        foreach ($fileURL as $url) {
            $this->stylesheets[] = $url;
        }
        return $this;
    }

    public function removeStylesheets() : self
    {
        $this->stylesheets = [];
        return $this;
    }

    public function getScripts() : string
    {
        return mapHTMLTag('<script src="{{ value }}"></script>', $this->scripts);
    }

    public function getStylesheets() : string
    {
        return mapHTMLTag('<link rel="stylesheet" type="text/css" href="{{ value }}">', $this->stylesheets);
    }

    public function setBody(string $body) : self
    {
        $this->body = $body;
        return $this;
    }

    public function getContentInfo() : ContentInfo
    {
        return $this->contentInfo;
    }

    /**
     * @see HTTPStatus
     */
    protected function overrideContentStatus(int $status, string $msg = '')
    {
        if (! $msg) {
            switch ($status) {
                case HTTPStatus::NotFound:
                    $msg = "Hum... Seem lost...\nThe requested page no longer exists.";
                    break;
                case HTTPStatus::InternalServerError:
                    $msg = "Hum... Sorry...\nThe requested page raised an uncatched error.";
                    break;
                case HTTPStatus::Unauthorized:
                    $msg = "Hum... Sorry...\nYou don't have the authorization to view this page.";
                    break;
            }
        }

        $this->setBody('
            <div class="singlePage">
                <div class="flex-grow"></div>
                <div>
                    <h1 class="text-center fw-light" style="font-size:300%;">'.html(App::getSiteTitle()).'</h1>
                    <div class="box p-xl">
                        <h3 class="m-0 pb-lg border-bottom">' . html(I18n::get('Error_' . $status)) .' <div class="fs-80 text-muted">Code '.$status.'</div></h3>
                        <div class="pb-lg my-lg border-bottom">'.nl2br(html($msg)).'</div>

                        <div class="flex text-center">
                        <a class="button dark flex-grow mr-sm" href="javascript:history.back()"><i class="fa fa-chevron-left"></i> Back</a>
                        <a class="button dark flex-grow ml-sm" href="/"><i class="fa fa-home"></i> Home</a>
                        </div>
                    </div>
                </div>
                <div class="flex-grow"></div>
            </div>
        ');
    }

    public function deliver(HTTPStatus $status = HTTPStatus::OK): never
    {
        // if (HTTPStatus::isError($status)) {
        //     $this->overrideContentStatus($status);
        // }
        $contentInfo = new ContentInfo(ContentType::HTML, Charset::UTF8, $status);
        $http = new HTTP($contentInfo);
        $http->deliver($this);
    }

    public function __toString() : string
    {
        return implode("\n", [
            '<!doctype html>',
            '<html lang="' . Langs::html($this->lang) . '">',
            '<head>',
                '<title>' . $this->title . '</title>',
                '<meta charset="utf-8">',
                '<meta name="viewport" content="width=device-width, initial-scale=1">',
                $this->getStylesheets(),
                '<title>' . implode(' - ', array_filter([$this->title, App::getSiteTitle()])) . '</title>',
            '</head><body>',
                $this->body,
                $this->getScripts(),
            '</body></html>',
        ]);
    }
}
