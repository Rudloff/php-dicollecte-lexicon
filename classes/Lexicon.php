<?php

namespace Dicollecte;

use League\Csv;
use Symfony\Component\Process\ProcessBuilder;

class Lexicon
{
    private $file;
    private $delimiter = "\t";
    private $procBuilder;

    /**
     * @param string $path
     */
    public function __construct($path)
    {
        $this->file = $path;
        $this->procBuilder = new ProcessBuilder();
        $this->procBuilder->setPrefix(['fgrep', $this->file]);
    }

    /**
     * @param string $column
     */
    private function getBy($search, $column)
    {
        $search = mb_strtolower($search, mb_detect_encoding($search));
        $this->procBuilder->setArguments(['-e', "\t$search\t"]);
        $process = $this->procBuilder->getProcess();
        $process->run();
        $csv = Csv\Reader::createFromString($process->getOutput());
        $csv->setDelimiter($this->delimiter);
        $results = [];
        foreach ($csv->fetchAssoc(['id', 'inflection', 'lemma', 'tags']) as $row) {
            if ($row[$column] == $search) {
                $results[] = new Inflection($row['id'], $row['inflection'], $row['lemma'], explode(' ', $row['tags']));
            }
        }

        return $results;
    }

    public function getByInflection($search)
    {
        return $this->getBy($search, 'inflection');
    }

    public function getByLemma($search)
    {
        return $this->getBy($search, 'lemma');
    }
}
