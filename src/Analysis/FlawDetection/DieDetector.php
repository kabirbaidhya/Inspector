<?php

namespace Inspector\Analysis\FlawDetection;

use PhpParser\Node;
use PhpParser\Node\Expr\Exit_;
use Inspector\Analysis\Exception\DieDetectedException;

/**
 * Detects the use of die() or exit() from the code
 */
class DieDetector implements CheckerInterface
{

    /**
     * @param Node $node
     * @throws DieDetectedException
     */
    public function check(Node $node)
    {
        if ($node instanceof Exit_) {
            throw (new DieDetectedException())->setNode($node);
        }
    }
}
