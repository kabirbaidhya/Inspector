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
     * @var ReportService
     */
    private $reportService;

    /**
     * @param Analyzer $analyzer
     * @param CodeScanner $scanner
     * @param FeedbackInterface $feedback
     * @param ReportService $reportService
     */
    public function __construct(
        Analyzer $analyzer,
        CodeScanner $scanner,
        FeedbackInterface $feedback,
        ReportService $reportService
    ) {
        $this->analyzer = $analyzer;
        $this->scanner = $scanner;
        $this->feedback = $feedback;
        $this->reportService = $reportService;
    }

    /**
     * @param string $path
     * @param array $options
     * @return string
     */
    public function analyze($path, array $options)
    {
        $source = $this->scanner->scan($path);

        $result = $this->analyzer->analyze($source, [
            'basePath' => realpath($path),
            'options' => $options
        ]);

        if ($options['generate-report'] === true) {
            $path = $options['path'];
            $this->reportService->generateReport($result, $path);

            return sprintf('Report generated to %s ', $path);
        } else {
            $feedback = $this->feedback->generate($result);

            return $feedback;
        }
    }

}
