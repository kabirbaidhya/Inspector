<?php

namespace Inspector\Analysis\Complexity;

use PhpParser\Node;

/**
 * Checks the complexity value of unit node.
 *
 * @author Kabir Baidhya
 */
interface ValueCheckerInterface
{

    /**
     * Checks the complexity value of any node.
     *
     * @param Node $node
     * @return int
     */
    public function getValue(Node $node);
}
