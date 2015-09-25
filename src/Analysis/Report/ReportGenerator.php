<?php


namespace Inspector\Analysis\Report;

use Illuminate\Filesystem\Filesystem;
use Inspector\Analysis\Result\AnalysisResult;


/**
 * @author Kabir Baidhya
 */
class ReportGenerator
{

    /**
     * @var Filesystem
     */
    protected $filesystem;

    /**
     * @var AnalysisResult
     */
    protected $result;

    /**
     * @param Filesystem $filesystem
     */
    public function __construct(Filesystem $filesystem)
    {
        $this->filesystem = $filesystem;
    }

    /**
     * @param AnalysisResult $result
     * @return $this
     */
    public function setAnalysisResult(AnalysisResult $result)
    {
        $this->result = $result;

        return $this;
    }

    /**
     * @param $path
     */
    public function generateTo($path)
    {
        $this->setupDirectory($path);

        $html = $this->renderReport($this->result);

        // Write report html to the file
        $this->filesystem->put($path . '/index.html', $html);
    }

    /**
     * Sets up the report directory.
     *
     * @param string $path
     * @return $this
     */
    protected function setupDirectory($path)
    {
        $src = BASEPATH . 'resources/output/html';
        $this->filesystem->copyDirectory($src, $path);

        return $this;
    }

    /**
     * Renders the Report HTML and returns it
     *
     * @param AnalysisResult $analysis
     * @return string
     */
    protected function renderReport(AnalysisResult $analysis)
    {
        ob_start();
        require(BASEPATH . 'resources/view/report.php');

        return ob_get_clean();
    }
}
