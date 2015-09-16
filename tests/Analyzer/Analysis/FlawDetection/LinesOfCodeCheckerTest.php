<?php

namespace Analyzer\Test;

use PhpParser\Parser;
use Analyzer\Analysis\FlawDetection\LinesOfCodeChecker;
use Analyzer\Analysis\Exception\ClassTooLongException;
use Analyzer\Analysis\Exception\MethodTooLongException;
use Analyzer\Analysis\Exception\FunctionTooLongException;

class LinesOfCodeCheckerTest extends TestCase
{

    /**
     * @var LinesOfCodeChecker
     */
    protected $locChecker;

    /**
     * @var Parser
     */
    protected $parser;

    protected function _before()
    {
        $this->locChecker = new LinesOfCodeChecker();
        $this->parser = $this->getContainer()->make('parser');
    }

    public function testCheckPassesForAFunction()
    {
        $code = file_get_contents(STUBPATH . 'CCN/function_1.php');
        $result = $this->checkFor($code);

        $this->assertTrue($result);
    }

    public function testCheckPassesForAClass()
    {
        $code = file_get_contents(STUBPATH . 'CCN/class_1.php');
        $result = $this->checkFor($code);

        $this->assertTrue($result);
    }

    public function testCheckPassesForANamespacedClass()
    {
        $code = file_get_contents(STUBPATH . 'CCN/namespaced_class_1.php');
        $result = $this->checkFor($code);

        $this->assertTrue($result);
    }

    public function testCheckPassesForANamespacedFunction()
    {
        $code = file_get_contents(STUBPATH . 'CCN/namespaced_function_1.php');
        $result = $this->checkFor($code);

        $this->assertTrue($result);
    }

    public function testCheckFailsForAVeryLongClassMethod()
    {
        $this->setExpectedException(MethodTooLongException::class);
        $code = file_get_contents(STUBPATH . 'long_class_method.php');
        $this->checkFor($code);
    }

    public function testCheckFailsForAVeryLongFunction()
    {
        $this->setExpectedException(FunctionTooLongException::class);
        $code = file_get_contents(STUBPATH . 'long_function.php');
        $this->checkFor($code);
    }

    public function testCheckFailsForAVeryLongClass()
    {
        $this->setExpectedException(ClassTooLongException::class);
        $code = file_get_contents(STUBPATH . 'long_class.php');
        $this->checkFor($code);
    }

    protected function checkFor($code)
    {
        $ast = $this->parser->parse($code);

        return $this->locChecker->setThreshold([
            LinesOfCodeChecker::THRESHOLD_CLASS => 500,
            LinesOfCodeChecker::THRESHOLD_METHOD => 80,
            LinesOfCodeChecker::THRESHOLD_FUNCTION => 80
        ])->check($ast);
    }
}
