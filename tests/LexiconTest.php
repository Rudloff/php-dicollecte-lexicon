<?php
namespace Dicollecte\Test;

use Dicollecte\Lexicon;

class LexiconTest extends \PHPUnit_Framework_TestCase
{
    protected function setUp()
    {
        $this->lexicon = new Lexicon();
    }

    /**
     * @dataProvider inflectionProvider
     */
    public function testGetLemma($inflection, $result)
    {
        $this->assertEquals($result, $this->lexicon->getLemma($inflection));
    }

    public function inflectionProvider()
    {
        return array(
           array('chanteuse', 'chanteur'),
           array('actrice', 'acteur'),
           array('maire', 'maire'),
           array('artisane', 'artisan'),
           array('nombreuse', 'nombreux'),
           array('foobar', 'foobar')
        );
    }
}
