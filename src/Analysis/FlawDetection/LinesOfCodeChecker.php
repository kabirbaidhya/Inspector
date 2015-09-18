<?php

namespace Analyzer\Analysis\FlawDetection;

use PhpParser\Node;
use PhpParser\Node\Stmt\Class_;
use PhpParser\Node\Stmt\Function_;
use PhpParser\Node\Stmt\ClassMethod;
use Analyzer\Misc\ParametersInterface;
use Analyzer\Analysis\Exception\ClassTooLongException;
use Analyzer\Analysis\Exception\MethodTooLongException;
use Analyzer\Analysis\Exception\FunctionTooLongException;

/**
 * The Line of Code Checker
 */
class LinesOfCodeChecker implements CheckerInterface, ParametersInterface
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
     * @param Node $node
     * @throws ClassTooLongException
     * @throws MethodTooLongException
     * @throws FunctionTooLongException
     */
    public function check(Node $node)
    {
        if ($node instanceof Function_) {
            $this->checkFunction($node);
        } elseif ($node instanceof ClassMethod) {
            $this->checkClassMethod($node);
        } elseif ($node instanceof Class_) {
            $this->checkClass($node);
        }

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
     * @param Function_ $node
     * @throws FunctionTooLongException
     */
    protected function checkFunction(Function_ $node)
    {
        if ($this->isTooLong($node, $this->thresholds[self::THRESHOLD_FUNCTION])) {
            throw (new FunctionTooLongException())->setNode($node);
        }
    }

    /**
     * @param ClassMethod $node
     * @throws MethodTooLongException
     */
    protected function checkClassMethod(ClassMethod $node)
    {
        if ($this->isTooLong($node, $this->thresholds[self::THRESHOLD_METHOD])) {
            throw (new MethodTooLongException())->setNode($node);
        }
    }

    /**
     * @param Class_ $node
     * @throws ClassTooLongException
     */
    protected function checkClass(Class_ $node)
    {
        if ($this->isTooLong($node, $this->thresholds[self::THRESHOLD_CLASS])) {
            throw (new ClassTooLongException())->setNode($node);
        }
    }

    /**
     * @param array $params
     * @return mixed
     */
    public function setParameters(array $params)
    {
        $this->thresholds = $params['loc_threshold'];

        return $this;
    }
}
