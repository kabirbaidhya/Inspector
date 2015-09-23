<?php

namespace Inspector\Analysis\FlawDetection;

use PhpParser\Node;
use PhpParser\Node\Stmt\ClassMethod;
use Inspector\Misc\ParametersInterface;
use Inspector\Analysis\Complexity\ComplexityComputer;
use Inspector\Analysis\Exception\MethodTooComplexException;
use Inspector\Analysis\Complexity\ComplexityComputerAwareInterface;

abstract class AbstractComplexityChecker implements CheckerInterface, ParametersInterface, ComplexityComputerAwareInterface
{

    /**
     * @var ComplexityComputer
     */
    protected $complexityComputer;

    /**
     * @var int
     */
    protected $threshold;

    /**
     * @param ComplexityComputer $complexityComputer
     * @return $this
     */
    public function setComplexityComputer(ComplexityComputer $complexityComputer)
    {
        $this->complexityComputer = $complexityComputer;

        return $this;
    }

    /**
     * Checks to make sure the class method is not that complex
     *
     * @param Node $node
     * @throws MethodTooComplexException
     */
    public function check(Node $node)
    {
        if ($node instanceof ClassMethod) {
            $complexity = $this->complexityComputer->compute($node);

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
        $complexity = $this->complexityComputer->compute($node);

        return ($complexity > $this->getThreshold());
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
