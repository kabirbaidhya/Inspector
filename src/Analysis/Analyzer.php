<?php

namespace Inspector\Analysis;

use PhpParser\Parser;
use Inspector\Analysis\Result\Issue;
use Inspector\Filesystem\SourceIterator;
use Inspector\Analysis\Result\AnalyzedFile;
use Inspector\Foundation\MessageProviderAwareTrait;
use Inspector\Foundation\MessageProviderAwareInterface;

/**
 * @author Kabir Baidhya
 */
class Analyzer implements MessageProviderAwareInterface
{

    use MessageProviderAwareTrait;

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
     *
     * @param SourceIterator $source
     * @param array $options
     * @return array
     */
    public function analyze(SourceIterator $source, array $options)
    {
        $result = [];
        foreach ($source as $filename => $code) {
            $ast = $this->parser->parse($code);

            $issues = $this->getIssues($ast);
            $result[$filename] = new AnalyzedFile($filename, $issues);
        }

        return $result;
    }

    /**
     * @param $ast
     * @return Issue[]
     */
    protected function getIssues($ast)
    {
        $exceptions = $this->flawDetector->analyze($ast);
        $issues = $this->messageProvider->translateExceptions($exceptions);

        return $issues;
    }

}
