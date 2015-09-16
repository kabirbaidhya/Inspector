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

    public function testCalculateAgainstANamespacedFunction()
    {
        // The raw source code
        $code = file_get_contents(STUBPATH . 'CCN/namespaced_function_1.php');

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

    public function testCalculateAgainstANamespacedClass()
    {
        // The raw source code
        $code = file_get_contents(STUBPATH . 'CCN/namespaced_class_1.php');

        $ccn = $this->computeFor($code);
        $this->assertEquals(8, $ccn);
    }

    public function testCalculateComplexityOfAVeryComplexClassMethod()
    {
        $code = file_get_contents(STUBPATH . 'CCN/class_2.php');
        $ccn = $this->computeFor($code);
        $this->assertGreaterThan(16, $ccn);
    }

    public function testCalculateComplexityOfARefactoredClassMethod()
    {
        $code = file_get_contents(STUBPATH . 'CCN/class_3.php');
        $ccn = $this->computeFor($code);
        $this->assertLessThan(10, $ccn);
    }

    protected function computeFor($code)
    {
        $ast = $this->parser->parse($code);
        // Calculate the Cyclomatic Complexity Number
        $ccn = $this->computer->compute($ast);

        return $ccn;
    }
}
