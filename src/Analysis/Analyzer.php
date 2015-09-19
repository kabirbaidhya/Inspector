<?php

namespace Inspector\Analysis;

use Inspector\Filesystem\CodeScanner;
use PhpParser\Parser;
use Inspector\Filesystem\SourceReader;
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
     * @var CodeScanner
     */
    protected $scanner;

    /**
     * @var ComplexityComputer
     */
    protected $complexityComputer;

    /**
     * @var FlawDetector
     */
    protected $flawDetector;

    /**
     * @param CodeScanner $scanner
     * @param ComplexityComputer $complexityComputer
     * @param FlawDetector $flawDetector
     * @param Parser $parser
     */
    public function __construct(
        CodeScanner $scanner,
        ComplexityComputer $complexityComputer,
        FlawDetector $flawDetector,
        Parser $parser
    ) {
        $this->parser = $parser;
        $this->scanner = $scanner;
        $this->complexityComputer = $complexityComputer;
        $this->flawDetector = $flawDetector;
    }

    /**
     * @param string $path Full path to a file or directory
     * @param array $options
     * @return array
     */
    public function analyze($path, array $options = [])
    {
        $source = $this->scanner->scan($path);

        $result = [];
        foreach ($source as $filename => $code) {
            $ast = $this->parser->parse($code);

//            $result['complexity'] = $result['complexity'] + $this->complexityComputer->analyze($ast);
            $messages = $this->flawDetector->analyze($ast);
            $result = array_merge($result, $messages);
        }

        return $result;
    }

}
