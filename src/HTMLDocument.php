<?php

namespace Tivins\Framework;

class HTMLDocument
{
    protected string $siteTitle    = '';
    protected string $body         = '';
    protected string $pageTitle    = '';
    protected string $pageLang     = 'en';
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

    public function setSiteTitle(string $siteTitle) : self
    {
        $this->siteTitle = $siteTitle;
        return $this;
    }

    public function setPageTitle(string $pageTitle) : self
    {
        $this->pageTitle = $pageTitle;
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

    public function deliver()
    {
        $contentInfo = new ContentInfo(ContentType::HTML, Charset::UTF8);
        $http = new HTTP($contentInfo);
        $http->deliver($this);
    }

    public function __toString() : string
    {
        return implode("\n", [
            '<!doctype html>',
            '<html lang="' . $this->pageLang . '">',
            '<head>',
                '<meta charset="utf-8">',
                '<meta name="viewport" content="width=device-width, initial-scale=1">',
                $this->getStylesheets(),
                '<title>' . implode(' - ', array_filter([$this->pageTitle, $this->siteTitle])) . '</title>',
            '</head><body>',
                $this->body,
                $this->getScripts(),
            '</body></html>',
        ]);
    }
}
