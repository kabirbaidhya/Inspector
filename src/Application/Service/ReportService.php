<?php


namespace Inspector\Application\Service;

use Inspector\Analysis\Report\ReportGenerator;
use Inspector\Analysis\Result\AnalysisResult;


/**
 * @author Kabir Baidhya
 */
class ReportService
{

    /**
     * @var ReportGenerator
     */
    private $reportGenerator;

    /**
     * @param ReportGenerator $reportGenerator
     */
    public function __construct(ReportGenerator $reportGenerator)
    {
        $this->reportGenerator = $reportGenerator;
    }

    public function generateReport(AnalysisResult $result, $path)
    {
        $path = realpath($path) . '/inspector-report';
        $this->reportGenerator
            ->setAnalysisResult($result)
            ->generateTo($path);
    }

}
