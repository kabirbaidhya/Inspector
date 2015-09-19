<?php

namespace Inspector\Test;

use PhpParser\Parser;
use PhpParser\Node\Stmt\Class_;
use Inspector\Analysis\Exception\ClassTooLongException;
use Inspector\Analysis\FlawDetection\LinesOfCodeChecker;
use Inspector\Analysis\Exception\MethodTooLongException;
use Inspector\Analysis\Exception\FunctionTooLongException;

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
        $this->locChecker->setParameters([
            'loc_threshold' => [
                LinesOfCodeChecker::THRESHOLD_CLASS => 500,
                LinesOfCodeChecker::THRESHOLD_METHOD => 80,
                LinesOfCodeChecker::THRESHOLD_FUNCTION => 80
            ]
        ]);
        $this->parser = $this->getContainer()->make('parser');
    }

    public function testCheckPassesForAFunction()
    {
        $code = file_get_contents(STUBPATH . 'CCN/function_1.php');
        $node = $this->parser->parse($code);
        $this->locChecker->check(current($node));
    }

    public function testCheckPassesForAClass()
    {
        $code = file_get_contents(STUBPATH . 'CCN/class_1.php');
        $node = $this->parser->parse($code);
        $this->locChecker->check(current($node));
    }

    public function testCheckFailsForAVeryLongClassMethod()
    {
        $this->setExpectedException(MethodTooLongException::class);
        $code = file_get_contents(STUBPATH . 'long_class_method.php');
        $ast = $this->parser->parse($code);

        /** @var Class_ $node */
        $node = current($ast);
        $this->locChecker->check($node->stmts[0]);
    }

    public function testCheckFailsForAVeryLongFunction()
    {
        $this->setExpectedException(FunctionTooLongException::class);
        $code = file_get_contents(STUBPATH . 'long_function.php');
        $ast = $this->parser->parse($code);
        $this->locChecker->check(current($ast));
    }

    public function testCheckFailsForAVeryLongClass()
    {
        $this->setExpectedException(ClassTooLongException::class);
        $code = file_get_contents(STUBPATH . 'long_class.php');
        $ast = $this->parser->parse($code);
        $this->locChecker->check(current($ast));
    }

}
