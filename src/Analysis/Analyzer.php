<?php

namespace Inspector\Analysis;

use PhpParser\Parser;
use Inspector\Filesystem\SourceIterator;
use Inspector\Analysis\Result\AnalyzedFile;
use Inspector\Analysis\Result\AnalysisResult;

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
     * @param array $params
     * @return AnalysisResult
     */
    public function analyze(SourceIterator $source, array $params = [])
    {
        $result = [];
        foreach ($source as $filename => $code) {
            $ast = $this->parser->parse($code);

            $issues = $this->flawDetector->analyze($ast);
            $result[$filename] = new AnalyzedFile($filename, $issues);
        }

        return new AnalysisResult($params['basePath'], $result);
    }

}
