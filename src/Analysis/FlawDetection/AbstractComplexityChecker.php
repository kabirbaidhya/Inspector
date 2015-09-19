<?php

namespace Inspector\Analysis\FlawDetection;

use PhpParser\Node;
use PhpParser\Node\Stmt\ClassMethod;
use Inspector\Misc\ParametersInterface;
use Inspector\Analysis\ComplexityComputer;
use Inspector\Analysis\Exception\MethodTooComplexException;

abstract class AbstractComplexityChecker implements CheckerInterface, ParametersInterface
{

    /**
     * @var int
     */
    protected $threshold;

    /**
     * Checks to make sure the class method is not that complex
     *
     * @param Node $node
     * @throws MethodTooComplexException
     */
    public function check(Node $node)
    {
        $complexityComputer = new ComplexityComputer();
        if ($node instanceof ClassMethod) {
            $complexity = $complexityComputer->compute($node);

            if ($complexity > $this->threshold) {
                throw (new MethodTooComplexException)->setNode($node);
            }
        }
    }

    /**
     * Checks if a part of code is complex
     *
     * @param Node $node
     * @return bool
     */
    protected function isComplex(Node $node)
    {
        $complexity = $this->complexityComputer()->compute($node);

        return ($complexity > $this->getThreshold());
    }

    /**
     * @return ComplexityComputer
     */
    protected function complexityComputer()
    {
        return new ComplexityComputer();
    }

    /**
     * @return int
     */
    public function getThreshold()
    {
        return $this->threshold;
    }

    /**
     * @param int $threshold
     * @return $this
     */
    public function setThreshold($threshold)
    {
        $this->threshold = $threshold;

        return $this;
    }

}
