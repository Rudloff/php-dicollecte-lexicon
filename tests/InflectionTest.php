<?php

namespace Dicollecte\Test;

use Dicollecte\Inflection;

class InflectionTest extends \PHPUnit_Framework_TestCase
{
    public function testHasTag()
    {
        $inflection = new Inflection(42, 'foo', 'foo', ['foo']);
        $this->assertTrue($inflection->hasTag('foo'));
        $this->assertFalse($inflection->hasTag('bar'));
    }
}
