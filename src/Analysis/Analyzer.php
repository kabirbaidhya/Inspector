<?php

namespace Inspector\Analysis;

use PhpParser\Parser;
use Inspector\Filesystem\SourceReader;
use Inspector\Filesystem\SourceIterator;
use Inspector\Filesystem\SourceCodeIterator;

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

            $result[$filename] = $this->flawDetector->analyze($ast);
        }

        return $result;
    }

}
