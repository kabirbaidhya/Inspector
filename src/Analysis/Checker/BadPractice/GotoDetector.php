<?php

namespace Inspector\Analysis\Checker\BadPractice;

use PhpParser\Node;
use PhpParser\Node\Stmt\Goto_;
use Inspector\Analysis\Checker\CheckerInterface;
use Inspector\Analysis\Exception\GotoDetectedException;

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
