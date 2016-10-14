<?php
/**
 * Lexicon class
 */
namespace Dicollecte;

use League\Csv;
use Symfony\Component\Process\ProcessBuilder;

/**
 * Class used to parse the lexicon
 */
class Lexicon
{
    /**
     * Path to the lexicon file.
     * This must be CSV file in the Dicollect format
     * @var string
     */
    private $file;

    /**
     * Delimiter used in CSV file
     * @var string
     */
    private $delimiter = "\t";

    /**
     * ProcessBuilder instance used to run fgrep
     * @var ProcessBuilder
     */
    private $procBuilder;

    /**
     * Lexicon constructor
     * @param string $path Path to the lexicon file
     */
    public function __construct($path)
    {
        $this->file = $path;
        $this->procBuilder = new ProcessBuilder();
        $this->procBuilder->setPrefix(['fgrep', $this->file]);
    }

    /**
     * Get inflections by searching in a specific column
     * @param  string $search String to search
     * @param  string $column Column name
     * @return Inflection[] Search results
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

    /**
     * Get inflections by inflected form
     * @param  string $search String to search
     * @return Inflection[] Search results
     */
    public function getByInflection($search)
    {
        return $this->getBy($search, 'inflection');
    }

    /**
     * Get inflections by lemma
     * @param  string $search String to search
     * @return Inflection[] Search results
     */
    public function getByLemma($search)
    {
        return $this->getBy($search, 'lemma');
    }
}
