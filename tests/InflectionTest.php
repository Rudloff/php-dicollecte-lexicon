<?php
/**
 * InflectionTest class.
 */

namespace Dicollecte\Test;

use Dicollecte\Inflection;

/**
 * Class used to test the Inflection class.
 */
class InflectionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test the hasTag() function.
     *
     * @return void
     */
    public function testHasTag()
    {
        $inflection = new Inflection(42, 'foo', 'foo', ['foo']);
        $this->assertTrue($inflection->hasTag('foo'));
        $this->assertFalse($inflection->hasTag('bar'));
    }
}
