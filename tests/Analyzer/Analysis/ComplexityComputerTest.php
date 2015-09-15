<?php
namespace Analyzer\Test;

use PhpParser\Parser;
use Analyzer\Analysis\ComplexityComputer;

class ComplexityComputerTest extends TestCase
{

    /**
     * @var ComplexityComputer
     */
    protected $computer;

    /**
     * @var Parser
     */
    protected $parser;

    protected function _before()
    {
        $this->computer = new ComplexityComputer();
        $this->parser = $this->getContainer()->make('parser');
    }

    public function testCalculateAgainstAFunction()
    {
        // The raw source code
        $code = file_get_contents(STUBPATH . 'CCN/function_1.php');

        $ccn = $this->computeFor($code);

        $this->assertEquals(8, $ccn);
    }

    public function testCalculateAgainstAClass()
    {
        // The raw source code
        $code = file_get_contents(STUBPATH . 'CCN/class_1.php');

        $ccn = $this->computeFor($code);
        $this->assertEquals(8, $ccn);
    }

    protected function computeFor($code)
    {
        $ast = $this->parser->parse($code);
        // Calculate the Cyclomatic Complexity Number
        $ccn = $this->computer->compute($ast);

        return $ccn;
    }
}
