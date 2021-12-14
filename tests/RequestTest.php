<?php

namespace Tivins\Framework\Tests;

use PHPUnit\Framework\TestCase;
use Tivins\Framework\{ContentType, Request};

class RequestTest extends TestCase
{
    public function testCLI()
    {
        $this->assertTrue((new Request())->isCLI());
    }

    public function testAccept()
    {
        $this->assertEquals(ContentType::TEXT, (new Request())->getPrimaryAccept());
    }

    /**
     * @see Request::parseQualityValues()
     */
    public function testParseQualityValues()
    {
        $ret = Request::parseQualityValues("application/json, text/css;q=.1, text/plain;q=0.9");
        $this->assertEquals('{"application\/json":1,"text\/plain":0.9,"text\/css":0.1}', json_encode($ret));
    }
}