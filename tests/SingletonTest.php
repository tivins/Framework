<?php

namespace Tivins\Framework\Tests;

use PHPUnit\Framework\TestCase;
use Tivins\Framework\Singleton;

class TestClassA extends Singleton {}

class SingletonTest extends TestCase
{
    public function testInstance()
    {
        $i1 = TestClassA::getInstance();
        $i2 = TestClassA::getInstance();
        $this->assertEquals($i1, $i2);
    }
}
