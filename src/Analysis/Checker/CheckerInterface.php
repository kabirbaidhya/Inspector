<?php

namespace Inspector\Analysis\Checker;

use PhpParser\Node;
use Inspector\Application\Exception\Exception;
use Inspector\Analysis\Exception\AnalysisException;

interface CheckerInterface
{

    /**
     * Checks to make sure the classes, methods, and functions are up to the standards
     * and don't use bad practices
     *
     * @param Node $node
     * @throws Exception
     * @throws AnalysisException
     */
    public function check(Node $node);
}
