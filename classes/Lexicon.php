<?php
namespace Dicollecte;

use League\Csv;

class Lexicon
{
    private $csv;

    public function __construct()
    {
        $this->csv = Csv\Reader::createFromPath(
            __DIR__.'/../vendor/dicollecte/lexique/lexique-dicollecte-fr-v5.6.txt',
            'r'
        );
        $this->csv->setDelimiter("\t");
    }

    public function getLemma($inflection)
    {
        $this->csv->addFilter(
            function ($row) use ($inflection) {
                return isset($row[1]) && $row[1] == $inflection;
            }
        );
        foreach ($this->csv->fetchColumn(2) as $lemma) {
            return $lemma;
        }
        return $inflection;
    }
}
