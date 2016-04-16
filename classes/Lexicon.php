<?php
namespace Dicollecte;

use League\Csv;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\ProcessBuilder;

class Lexicon
{
    private $file;
    private $delimiter = "\t";
    private $procBuilder;

    public function __construct($path)
    {
        $this->file = $path;
        $this->procBuilder = new ProcessBuilder();
        $this->procBuilder->setPrefix(array('fgrep', $this->file));
    }

    private function getBy($search, $column)
    {
        $search = strtolower($search);
        $this->procBuilder->setArguments(array('-e', "\t$search\t"));
        $process = $this->procBuilder->getProcess();
        $process->run();
        $csv = Csv\Reader::createFromString($process->getOutput());
        $csv->setDelimiter($this->delimiter);
        $results = array();
        foreach ($csv->fetchAssoc(array('id', 'inflection', 'lemma', 'tags')) as $row) {
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
