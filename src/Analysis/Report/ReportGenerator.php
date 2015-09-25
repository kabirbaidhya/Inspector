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
     * @param Filesystem $filesystem
     */
    public function __construct(Filesystem $filesystem)
    {
        $this->filesystem = $filesystem;
    }

    /**
     * @param $path
     * @param array $data
     */
    public function generate($path, array $data)
    {
        $this->setupDirectory($path);
        $html = $this->renderReport([
            'analyzedPath' => $data['path'],
            'analysis' => $data['result']
        ]);

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
     * @param array $data
     * @return string
     */
    protected function renderReport(array $data)
    {
        extract($data);
        ob_start();
        require(BASEPATH . 'resources/view/report.php');

        return ob_get_clean();
    }
}
