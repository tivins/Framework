<?php

namespace Tivins\Framework;

class HTMLDocument
{
    private string $siteTitle    = '';
    private string $pageTitle    = '';
    private string $pageLang     = 'en';
    private array  $scripts      = [];
    private array  $stylesheets  = [];


    public function addScript(string ...$fileURL) : self
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

    public function addCSS(string ...$fileURL) : self
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

    public function render(string $body) : string
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
                $body,
                $this->getScripts(),
            '</body></html>',
        ]);
    }
}
