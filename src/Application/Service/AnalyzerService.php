<?php
/**
 * @author Kabir Baidhya
 */

namespace Inspector\Application\Service;


use Inspector\Analysis\Analyzer;
use Inspector\Analysis\Exception\AnalysisException;
use Inspector\Analysis\Feedback\FeedbackInterface;
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
     * @var FeedbackInterface
     */
    private $feedback;

    /**
     * @param Analyzer $analyzer
     * @param CodeScanner $scanner
     * @param FeedbackInterface $feedback
     */
    public function __construct(Analyzer $analyzer, CodeScanner $scanner, FeedbackInterface $feedback)
    {
        $this->analyzer = $analyzer;
        $this->scanner = $scanner;
        $this->feedback = $feedback;
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
        $messages = $this->analyzer->analyze($source, $options);

        $feedback = $this->feedback->generate($messages);

        return $feedback;
    }
}
