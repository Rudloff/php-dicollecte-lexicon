<?php
/**
 * Inflection class.
 */

namespace Dicollecte;

/**
 * Class used to manage inflections.
 */
class Inflection
{
    /**
     * Inflection ID in the lexicon.
     *
     * @var int
     */
    private $id;

    /**
     * Inflected form.
     *
     * @var string
     */
    public $inflection;

    /**
     * Lemma.
     *
     * @var string
     */
    public $lemma;

    /**
     * Tags.
     *
     * @var string[]
     */
    public $tags = [];

    /**
     * Inflection constructor.
     *
     * @param int      $id         Inflection ID in the lexicon
     * @param string   $inflection Inflected form
     * @param string   $lemma      Lemma
     * @param string[] $tags       Tags
     */
    public function __construct($id, $inflection, $lemma, $tags)
    {
        $this->id = (int) $id;
        $this->inflection = $inflection;
        $this->lemma = $lemma;
        $this->tags = $tags;
    }

    /**
     * Check if the inflection has a specific tag.
     *
     * @param string $tag Tag
     *
     * @return bool
     */
    public function hasTag($tag)
    {
        return in_array($tag, $this->tags);
    }
}
