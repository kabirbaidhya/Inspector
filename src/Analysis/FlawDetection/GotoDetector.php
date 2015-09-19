<?php

namespace Inspector\Analysis\FlawDetection;

use PhpParser\Node;
use Inspector\Analysis\Exception\GotoDetectedException;
use PhpParser\Node\Stmt\Goto_;

/**
 * Detects the use of die() or exit() from the code
 */
class GotoDetector implements CheckerInterface
{

    /**
     * @param Node $node
     * @throws GotoDetectedException
     */
    public function check(Node $node)
    {
        if ($node instanceof Goto_) {
            throw (new GotoDetectedException())->setNode($node);
        }
    }
}
