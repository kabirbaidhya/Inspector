<?php


namespace Inspector\Application\Service;

use Inspector\Analysis\Report\ReportGenerator;
use Inspector\Analysis\Result\AnalysisResult;
use Inspector\Foundation\AbstractService as Service;


/**
 * @author Kabir Baidhya
 */
class ReportService extends Service
{

    /**
     * @var ReportGenerator
     */
    protected $reportGenerator;

    /**
     * @param ReportGenerator $reportGenerator
     */
    public function __construct(ReportGenerator $reportGenerator)
    {
        $this->reportGenerator = $reportGenerator;
    }

    /**
     * @param array $data
     * @param string $path
     * @return array
     */
    public function generateReport(array $data, $path)
    {
        $path = realpath($path) . '/inspector-report';
        $this->reportGenerator->generate($path, $data);

        return compact('path');
    }

}
