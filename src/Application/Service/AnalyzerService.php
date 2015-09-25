<?php

namespace Inspector\Application\Service;

use Inspector\Analysis\Analyzer;
use Inspector\Analysis\Result\AnalysisResult;
use Inspector\Filesystem\CodeScanner;
use Inspector\Analysis\Feedback\FeedbackInterface;
use Inspector\Foundation\AbstractService as Service;

/**
 * @author Kabir Baidhya
 */
class AnalyzerService extends Service
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
    protected $feedback;

    /**
     * @var ReportService
     */
    protected $reportService;

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
        $path = realpath($path);
        $source = $this->scanner->scan($path);

        $rawResult = $this->analyzer->analyze($source, $options);
        $result = $this->process($rawResult);

        if ($options['generate-report'] === true) {
            $reportPath = $options['path'];
            $report = $this->reportService->generateReport(compact('result', 'path'), $reportPath);

            return sprintf('<info>Report generated to</info> %s ', $report['path']);
        } else {
            $feedback = $this->feedback->generate($result);

            return $feedback;
        }
    }

    /**
     * Process raw analysis raw result
     *
     * @param array $rawResult
     * @return AnalysisResult
     */
    public function process(array $rawResult)
    {
        foreach ($rawResult as &$file) {
//            $file->
        }

        return new AnalysisResult($rawResult);
    }

}
