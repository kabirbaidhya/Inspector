<?php

namespace Analyzer\Analysis;

use PhpParser\Node;
use PhpParser\Node\Stmt\If_;
use PhpParser\Node\Stmt\Do_;
use PhpParser\Node\Stmt\For_;
use PhpParser\Node\Stmt\Case_;
use PhpParser\Node\Stmt\While_;
use PhpParser\Node\Stmt\Catch_;
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
 * Computes the Cyclomatic complexity of a method/function
 * @author Kabir Baidhya
 *
 */
class ComplexityComputer
{

    /**
     * @param Node[]|null $ast Abstract Syntax Tree nodes
     * @return int The Cyclomatic Complexity Number
     */
    public function compute($ast)
    {
        if (empty($ast)) {
            return 0;
        }

        $value = 0;
        foreach ($ast as $node) {
            if (!($node instanceof Node)) {
                continue;
            }
            if ($this->hasComplexity($node)) {
                $value += 1;
            }

            foreach ($node->getSubNodeNames() as $subNodeName) {
                $subNode = $node->{$subNodeName};
                if (is_array($subNode)) {
                    $value += $this->compute($subNode);
                } elseif ($node instanceof Node) {
                    $value += $this->compute([$subNode]);
                }
            }

        }

        return $value;
    }

    /**
     * @param Node $node
     * @return bool
     */
    protected function hasComplexity(Node $node)
    {
        return (

            $node instanceof Function_ ||
            $node instanceof ClassMethod ||
            // the control structures
            $node instanceof If_ ||
            $node instanceof ElseIf_ ||
            $node instanceof For_ ||
            $node instanceof Foreach_ ||
            $node instanceof While_ ||
            $node instanceof Do_ ||
            $node instanceof Catch_ ||

            // excluding 'default' cases
            ($node instanceof Case_ && !empty($node->cond)) ||

            // logical operators
            $node instanceof LogicalAnd ||
            $node instanceof BooleanAnd ||
            $node instanceof LogicalOr ||
            $node instanceof BooleanOr ||
            $node instanceof BooleanNot ||
            $node instanceof LogicalXor
        );
    }
}
