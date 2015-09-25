<?php

namespace Inspector\Analysis\Complexity;

use PhpParser\Node;
use Inspector\Analysis\NodeWalker;

/**
 * Computes the Cyclomatic complexity of a AST node
 *
 * @author Kabir Baidhya
 */
class ComplexityComputer
{

    /**
     * @var ValueCheckerInterface
     */
    protected $complexityChecker;

    public function __construct(ValueCheckerInterface $complexityChecker)
    {
        $this->complexityChecker = $complexityChecker;
    }

    /**
     * Computes the complexity of a part of code.
     *
     * @param Node[]|Node|null $ast Abstract Syntax Tree node(s)
     * @return int The Cyclomatic Complexity Number
     */
    public function compute($ast)
    {
        $complexity = 0;
        $walker = new NodeWalker();

        // Walk through all the nodes one by one
        $walker->walk($ast, function (Node $node) use (&$complexity) {
            // Add the complexity value of the given node
            // to the overall complexity of the AST
            $complexity += $this->complexityChecker->getValue($node);
        });

        return $complexity;
    }

}
