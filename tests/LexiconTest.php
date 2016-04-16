<?php
namespace Dicollecte\Test;

use Dicollecte\Lexicon;
use Dicollecte\Inflection;

class LexiconTest extends \PHPUnit_Framework_TestCase
{
    protected function setUp()
    {
        $this->lexicon = new Lexicon();
    }

    /**
     * @dataProvider inflectionProvider
     */
    public function testGetByInflection($search, $result)
    {
        $this->assertEquals($result, $this->lexicon->getByInflection($search));
    }

    public function inflectionProvider()
    {
        return array(
            array('chanteuse', array(
                new Inflection(134848, 'chanteuse', 'chanteur', array('nom', 'adj', 'fem', 'sg')))
            ),
            array('Chanteuse', array(
                new Inflection(134848, 'chanteuse', 'chanteur', array('nom', 'adj', 'fem', 'sg')))
            ),
            array('maire', array(new Inflection(214625, 'maire', 'maire', array('nom', 'epi', 'sg')))),
            array('tête', array(new Inflection(178470, 'tête', 'tête', array('nom', 'fem', 'sg')))),
            array('fois', array(
                new Inflection(146987, 'fois', 'foi', array('nom', 'fem', 'pl')),
                new Inflection(200308, 'fois', 'fois', array('nom', 'fem', 'inv'))
            )),
            array('foobar', array())
        );
    }

    public function testGetByLemma()
    {
        $this->assertEquals(
            array(
                new Inflection(126701, 'administrateurs', 'administrateur', array('nom', 'adj', 'mas', 'pl')),
                new Inflection(126701, 'administrateur', 'administrateur', array('nom', 'adj', 'mas', 'sg')),
                new Inflection(126701, 'administratrice', 'administrateur', array('nom', 'adj', 'fem', 'sg')),
                new Inflection(126701, 'administratrices', 'administrateur', array('nom', 'adj', 'fem', 'pl')),
            ),
            $this->lexicon->getByLemma('administrateur')
        );
    }

    public function testHasTag()
    {
        foreach ($this->lexicon->getByInflection('administratrice') as $inflection) {
            $this->assertTrue($inflection->hasTag('fem'));
        }
    }
}
