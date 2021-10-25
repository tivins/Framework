<?php

namespace Tivins\Framework;

abstract class Document
{

    protected string $title    = '';
    protected string $lang     = 'en';


    public function setPageTitle(string $title) : self
    {
        $this->title = $title;
        return $this;
    }

    // -- abstract --

    abstract public function __toString(): string;
}
