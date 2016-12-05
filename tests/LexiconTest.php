<?php
/**
 * LexiconTest.
 */

namespace Dicollecte\Test;

use Dicollecte\Inflection;
use Dicollecte\Lexicon;

/**
 * Class used to test the Lexicon class.
 */
class LexiconTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Lexicon used in tests.
     *
     * @var Lexicon
     */
    private $lexicon;

    /**
     * Setup variables used by tests.
     */
    protected function setUp()
    {
        $this->lexicon = new Lexicon(__DIR__.'/lexicon.txt');
    }

    /**
     * Test the getByInflection function.
     *
     * @param string     $search String to search
     * @param Inflection $result Expected result
     *
     * @return void
     * @dataProvider inflectionProvider
     */
    public function testGetByInflection($search, $result)
    {
        $this->assertEquals($result, $this->lexicon->getByInflection($search));
    }

    /**
     * Provide inflection to use in tests.
     *
     * @return array[]
     */
    public function inflectionProvider()
    {
        return [
            ['chanteuse', [
                new Inflection(134848, 'chanteuse', 'chanteur', ['nom', 'adj', 'fem', 'sg']), ],
            ],
            ['Chanteuse', [
                new Inflection(134848, 'chanteuse', 'chanteur', ['nom', 'adj', 'fem', 'sg']), ],
            ],
            ['maire', [new Inflection(214625, 'maire', 'maire', ['nom', 'epi', 'sg'])]],
            ['tête', [new Inflection(178470, 'tête', 'tête', ['nom', 'fem', 'sg'])]],
            ['fois', [
                new Inflection(146987, 'fois', 'foi', ['nom', 'fem', 'pl']),
                new Inflection(200308, 'fois', 'fois', ['nom', 'fem', 'inv']),
            ]],
            ['étudiante', [
                new Inflection(182246, 'étudiante', 'étudiant', ['nom', 'adj', 'fem', 'sg']), ],
            ],
            ['foobar', []],
        ];
    }

    /**
     * Test the getByLemma() function.
     *
     * @return void
     */
    public function testGetByLemma()
    {
        $this->assertEquals(
            [
                new Inflection(126701, 'administrateurs', 'administrateur', ['nom', 'adj', 'mas', 'pl']),
                new Inflection(126701, 'administrateur', 'administrateur', ['nom', 'adj', 'mas', 'sg']),
                new Inflection(126701, 'administratrice', 'administrateur', ['nom', 'adj', 'fem', 'sg']),
                new Inflection(126701, 'administratrices', 'administrateur', ['nom', 'adj', 'fem', 'pl']),
            ],
            $this->lexicon->getByLemma('administrateur')
        );
    }

    /**
     * Test the hasTag function.
     *
     * @return void
     */
    public function testHasTag()
    {
        foreach ($this->lexicon->getByInflection('administratrice') as $inflection) {
            $this->assertTrue($inflection->hasTag('fem'));
        }
    }
}
