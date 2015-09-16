<?php

namespace Analyzer\Analysis\FlawDetection;

use PhpParser\Node;
use Analyzer\Application\Exception\Exception;
use Analyzer\Analysis\Exception\AnalysisException;

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
