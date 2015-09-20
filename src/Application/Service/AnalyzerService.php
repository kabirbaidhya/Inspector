<?php
/**
 * @author Kabir Baidhya
 */

namespace Inspector\Application\Service;


use Inspector\Analysis\Analyzer;
use Inspector\Analysis\Exception\AnalysisException;
use Inspector\Analysis\Feedback\TextGenerator;
use Inspector\Filesystem\CodeScanner;

class AnalyzerService
{

    /**
     * @var Analyzer
     */
    protected $analyzer;

    /**
     * @var CodeScanner
     */
    protected $scanner;

    /**
     * @param Analyzer $analyzer
     * @param CodeScanner $scanner
     */
    public function __construct(Analyzer $analyzer, CodeScanner $scanner)
    {
        $this->analyzer = $analyzer;
        $this->scanner = $scanner;
    }

    /**
     * @param string $path
     * @param array $options
     * @return string
     */
    public function analyze($path, array $options)
    {
        $source = $this->scanner->scan($path);

        /** @var  AnalysisException[] $feedback */
        $feedback = $this->analyzer->analyze($source, $options);

        $feedback = (new TextGenerator())->generate($feedback);

        return $feedback;
    }
}
