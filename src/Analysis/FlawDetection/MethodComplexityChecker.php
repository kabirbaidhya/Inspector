<?php

namespace Analyzer\Analysis\FlawDetection;

use PhpParser\Node;
use PhpParser\Node\Stmt\ClassMethod;
use Analyzer\Analysis\Exception\MethodTooComplexException;
use Analyzer\Analysis\FlawDetection\AbstractComplexityChecker as ComplexityChecker;

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
        $this->setParameters($params['complexity_threshold']['method']);

        return $this;
    }
}
