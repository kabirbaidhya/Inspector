<?php
namespace Analyzer\Test;

use PhpParser\Parser;
use Analyzer\Analysis\FlawDetector;
use Analyzer\Analysis\FlawDetection\LinesOfCodeChecker;

class FlawDetectorTest extends TestCase
{

    /**
     * @var FlawDetector
     */
    protected $flawDetector;

    /**
     * @var Parser
     */
    protected $parser;

    protected function _before()
    {
        $config = [
            'loc_threshold' => [
                LinesOfCodeChecker::THRESHOLD_CLASS => 500,
                LinesOfCodeChecker::THRESHOLD_METHOD => 80,
                LinesOfCodeChecker::THRESHOLD_FUNCTION => 80
            ]
        ];
        $this->flawDetector = new FlawDetector($config);
        $this->parser = $this->getContainer()->make('parser');
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
        $result = $this->analyze($code);
        $this->assertTrue(is_array($result));
    }

    protected function analyze($code)
    {
        $ast = $this->parser->parse($code);
        $result = $this->flawDetector->analyze($ast);

        return $result;
    }
}
