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
    private function overrideContentStatus(int $status)
    {
        $this->setBody('
            <div class="aaa" style="position: absolute;top: 0;left: 0;right: 0;bottom: 25vh;display: flex;align-items: center;">
                <div class="flex-grow"></div>
                <div>
                    <h1 class="text-center fw-light" style="font-size:300%;">'.html(App::getSiteTitle()).'</h1>
                    <div class="box p-xl">
                        <h3 class="m-0 pb-lg border-bottom">' . html(I18n::get('Error_' . $status)) .' <span class="text-muted">(Status '.$status.')</span></h3>
                        <div class="pb-lg my-lg border-bottom">Hum... Seem lost..<br>The requested page no longer exists.</div>

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

    public function deliver(int $status = HTTPStatus::OK)
    {
        if (HTTPStatus::isError($status)) {
            $this->overrideContentStatus($status);
        }
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
