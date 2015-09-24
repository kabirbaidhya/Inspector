<?php

namespace Inspector\Analysis;

use PhpParser\Parser;
use Inspector\Analysis\Result\Result;
use Inspector\Filesystem\SourceIterator;

/**
 * @author Kabir Baidhya
 */
class Analyzer
{

    /**
     * @var Parser
     */
    protected $parser;

    /**
     * @var FlawDetector
     */
    protected $flawDetector;

    /**
     * @param Parser $parser
     * @param FlawDetector $flawDetector
     */
    public function __construct(Parser $parser, FlawDetector $flawDetector)
    {
        $this->parser = $parser;
        $this->flawDetector = $flawDetector;
    }

    /**
     * @param SourceIterator $source
     * @param array $options
     * @return array
     */
    public function analyze(SourceIterator $source, array $options = [])
    {
        $result = [];
        foreach ($source as $filename => $code) {
            $ast = $this->parser->parse($code);

            $issues = $this->flawDetector->analyze($ast);
            $result[$filename] = new Result($filename, $issues);
        }

        return $result;
    }

}
