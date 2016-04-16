<?php
namespace Dicollecte;

class Inflection
{
    private $id;
    public $inflection;
    public $lemma;
    public $tags = array();

    public function __construct($id, $inflection, $lemma, $tags)
    {
        $this->id = (int)$id;
        $this->inflection = $inflection;
        $this->lemma = $lemma;
        $this->tags = $tags;
    }

    public function hasTag($tag)
    {
        return in_array($tag, $this->tags);
    }
}
