<?php

namespace Inspector\Analysis\FlawDetection;

use PhpParser\Node;
use PhpParser\Node\Stmt\Class_;
use Inspector\Analysis\Exception\ClassTooComplexException;
use Inspector\Analysis\FlawDetection\AbstractComplexityChecker as ComplexityChecker;

class ClassComplexityChecker extends ComplexityChecker
{

    /**
     * Checks to make sure the class is not that complex
     *
     * @param Node $node
     * @throws ClassTooComplexException
     */
    public function check(Node $node)
    {
        if (($node instanceof Class_) && $this->isComplex($node)) {
            throw (new ClassTooComplexException())->setNode($node);
        }
    }

    /**
     * @param array $params
     * @return $this
     */
    public function setParameters(array $params)
    {
        $this->setThreshold($params['complexity_threshold']['class']);

        return $this;
    }
}
