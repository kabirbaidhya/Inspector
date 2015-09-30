<?php

namespace Inspector\Analysis\Checker\Complexity;

use PhpParser\Node;
use PhpParser\Node\Stmt\ClassMethod;
use Inspector\Analysis\Exception\MethodTooComplexException;
use Inspector\Analysis\Checker\Complexity\AbstractComplexityChecker as ComplexityChecker;

class MethodComplexityChecker extends ComplexityChecker
{

    /**
     * Checks to make sure the class method is not that complex
     *
     * @param Node $node
     * @throws MethodTooComplexException
     */
    public function check(Node $node)
    {
        if (($node instanceof ClassMethod) && $this->isComplex($node)) {
            throw (new MethodTooComplexException)->setNode($node);
        }
    }

    /**
     * @param array $params
     * @return $this
     */
    public function setParameters(array $params)
    {
        $this->setThreshold($params['complexity_threshold']['method']);

        return $this;
    }
}
