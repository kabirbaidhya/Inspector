<?php

namespace Analyzer\Analysis\FlawDetection;

use PhpParser\Node;
use PhpParser\Node\Stmt\Class_;
use PhpParser\Node\Stmt\Function_;
use PhpParser\Node\Stmt\Namespace_;
use PhpParser\Node\Stmt\ClassMethod;
use Analyzer\Application\Exception\Exception;
use Analyzer\Analysis\Exception\ClassTooLongException;
use Analyzer\Analysis\Exception\MethodTooLongException;
use Analyzer\Analysis\Exception\FunctionTooLongException;

/**
 * The Line of Code Checker
 */
class LinesOfCodeChecker implements CheckerInterface
{

    const THRESHOLD_CLASS = 'class';

    const THRESHOLD_METHOD = 'method';

    const THRESHOLD_FUNCTION = 'function';

    /**
     * @var array
     */
    protected $thresholds = [];


    /**
     * Checks to make sure the classes, methods, and functions are not
     * very long on the basis of Lines of Code
     *
     * @param Node[]|null $ast
     * @return bool
     * @throws Exception
     * @throws ClassTooLongException
     * @throws MethodTooLongException
     * @throws FunctionTooLongException
     */
    public function check($ast)
    {
        if (empty($ast)) {
            return true;
        }

        // throw exception if thresholds have not been set
        $this->checkThresholds();

        foreach ($ast as $node) {

            if ($node instanceof Function_) {
                $this->checkFunction($node);
            } elseif ($node instanceof ClassMethod) {
                $this->checkClassMethod($node);
            } elseif ($node instanceof Class_) {
                $this->checkClass($node);
                $this->check($node->stmts);
            } elseif ($node instanceof Namespace_) {
                $this->check($node->stmts);
            }

        }

        return true;
    }

    /**
     * Checks if a function, class or method is too long according to its lines of code
     *
     * @param Node $node
     * @param int $threshold
     * @return bool
     */
    protected function isTooLong(Node $node, $threshold)
    {
        $startLine = $node->getAttribute('startLine');
        $endLine = $node->getAttribute('endLine');

        $loc = $endLine - $startLine;

        return $loc > $threshold;
    }

    /**
     * @param array $thresholds
     * @return $this
     */
    public function setThreshold(array $thresholds)
    {
        $this->thresholds = $thresholds;

        return $this;
    }

    /**
     * @return array
     */
    public function getThresholds()
    {
        return $this->thresholds;
    }

    /**
     * @throws Exception
     */
    protected function checkThresholds()
    {
        if (
            empty($this->thresholds[self::THRESHOLD_CLASS]) ||
            empty($this->thresholds[self::THRESHOLD_METHOD]) ||
            empty($this->thresholds[self::THRESHOLD_FUNCTION])
        ) {
            throw new Exception('LocChecker thresholds have not been set.');
        }
    }

    /**
     * @param Function_ $node
     * @throws FunctionTooLongException
     */
    protected function checkFunction(Function_ $node)
    {
        if ($this->isTooLong($node, $this->thresholds[self::THRESHOLD_FUNCTION])) {
            throw new FunctionTooLongException();
        }
    }

    /**
     * @param ClassMethod $node
     * @throws MethodTooLongException
     */
    protected function checkClassMethod(ClassMethod $node)
    {
        if ($this->isTooLong($node, $this->thresholds[self::THRESHOLD_METHOD])) {
            throw new MethodTooLongException();
        }
    }

    /**
     * @param Class_ $node
     * @throws ClassTooLongException
     */
    protected function checkClass(Class_ $node)
    {
        if ($this->isTooLong($node, $this->thresholds[self::THRESHOLD_CLASS])) {
            throw new ClassTooLongException();
        }
    }

}
