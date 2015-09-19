<?php

namespace Inspector\Analysis\FlawDetection;

use PhpParser\Node;
use PhpParser\Node\Expr\Eval_;
use Inspector\Analysis\Exception\EvalDetectedException;

/**
 * Detects the use of eval()
 */
class EvalDetector implements CheckerInterface
{

    /**
     * @param Node $node
     * @throws EvalDetectedException
     */
    public function check(Node $node)
    {
        if ($node instanceof Eval_) {
            throw (new EvalDetectedException())->setNode($node);
        }
    }
}
