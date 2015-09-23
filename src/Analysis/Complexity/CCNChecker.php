<?php

namespace Inspector\Analysis\Complexity;

use PhpParser\Node;
use PhpParser\Node\Stmt\If_;
use PhpParser\Node\Stmt\Do_;
use PhpParser\Node\Stmt\For_;
use PhpParser\Node\Stmt\Case_;
use PhpParser\Node\Stmt\While_;
use PhpParser\Node\Stmt\Catch_;
use PhpParser\Node\Expr\Closure;
use PhpParser\Node\Stmt\ElseIf_;
use PhpParser\Node\Stmt\Foreach_;
use PhpParser\Node\Stmt\Function_;
use PhpParser\Node\Expr\BooleanNot;
use PhpParser\Node\Stmt\ClassMethod;
use PhpParser\Node\Expr\BinaryOp\BooleanOr;
use PhpParser\Node\Expr\BinaryOp\LogicalOr;
use PhpParser\Node\Expr\BinaryOp\BooleanAnd;
use PhpParser\Node\Expr\BinaryOp\LogicalAnd;
use PhpParser\Node\Expr\BinaryOp\LogicalXor;

/**
 * Class responsible for checking the Cylomatic Complexity Number (CCN) value of a node.
 *
 * @author Kabir Baidhya
 */
class CCNChecker implements ValueCheckerInterface
{

    /**
     * Checks the cyclomatic complexity value of a given node
     *
     * @param Node $node
     * @return int
     */
    public function getValue(Node $node)
    {
        $complexityAdders = $this->getComplexityAdders();

        foreach ($complexityAdders as $nodeClass) {
            if ($this->nodePassesFor($nodeClass, $node)) {
                return 1;
            }
        }

        return 0;
    }

    /**
     * Checks to make sure the node is an instance of complexity adder node classes,
     * and also passes any extra conditions (if any)
     *
     * @param array $nodeClass
     * @param Node $node
     * @return bool
     */
    protected function nodePassesFor(array $nodeClass, Node $node)
    {
        $class = array_shift($nodeClass);
        $callbackCondition = array_shift($nodeClass);

        // If node is an instance of a complexity adder class
        if (is_a($node, $class)) {

            if (!is_callable($callbackCondition)) {
                // if it doesn't have any extra callback condition then
                return true;
            } elseif ($callbackCondition($node)) {
                // if it has extra callback condition then that condition also
                // must hold true
                return true;
            }
        }

        return false;
    }

    /**
     * Get the class names of all the nodes which adds complexity in the code
     *
     * @return array
     */
    protected function getComplexityAdders()
    {
        return [
            // the control structures
            [If_::class],
            [ElseIf_::class],
            [For_::class],
            [Foreach_::class],
            [While_::class],
            [Do_::class],
            [Catch_::class],
            [
                Case_::class,
                function (Node $node) {
                    // Return true for all switch 'case' statements
                    // except the 'default' case
                    return !empty($node->cond);
                }
            ],
            // class methods, functions or closures(anonymous functions)
            [ClassMethod::class],
            [Function_::class],
            [Closure::class],
            // logical operators
            [LogicalAnd::class],
            [BooleanAnd::class],
            [LogicalOr::class],
            [BooleanOr::class],
            [BooleanNot::class],
            [LogicalXor::class],
        ];
    }
}
