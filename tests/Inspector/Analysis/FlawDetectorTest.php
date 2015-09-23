<?php
namespace Inspector\Test\Analysis;

use Inspector\Test\TestCase;
use Inspector\Analysis\FlawDetector;
use Inspector\Analysis\Exception\AnalysisException;

class FlawDetectorTest extends TestCase
{

    /**
     * @var FlawDetector
     */
    protected $flawDetector;

    protected function _before()
    {
        $this->flawDetector = $this->getContainer()->make('flaw-detector');
    }

    public function listOfFiles()
    {
        return [
            ['long_class.php'],
            ['long_class_method.php'],
            ['long_function.php'],
            ['CCN/class_1.php'],
            ['CCN/class_2.php'],
            ['CCN/class_3.php'],
            ['CCN/function_1.php'],
        ];
    }

    /**
     * @dataProvider listOfFiles
     * @param $filename
     */
    public function testFlawDetectorGivesBackMessages($filename)
    {
        $code = file_get_contents(STUBPATH . $filename);
        $ast = $this->getParser()->parse($code);
        $result = $this->flawDetector->analyze($ast);

        $this->assertArrayOf(AnalysisException::class, $result);
    }

}
