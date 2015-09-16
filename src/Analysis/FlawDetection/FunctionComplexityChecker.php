<?php

namespace Analyzer\Analysis\FlawDetection;

use PhpParser\Node;
use PhpParser\Node\Stmt\Function_;
use Analyzer\Analysis\Exception\FunctionTooComplexException;
use Analyzer\Analysis\FlawDetection\AbstractComplexityChecker as ComplexityChecker;

class FunctionComplexityChecker extends ComplexityChecker
{

    /**
     * Checks to make sure the function is not that complex
     *
     * @param Node $node
     * @throws FunctionTooComplexException
     */
    public function check(Node $node)
    {
        if (($node instanceof Function_) && $this->isComplex($node)) {
            throw (new FunctionTooComplexException())->setNode($node);
        }
    }

    /**
     * @param array $params
     * @return $this
     */
    public function setParameters(array $params)
    {
        $this->setThreshold($params['complexity_threshold']['function']);

        return $this;
    }
}
