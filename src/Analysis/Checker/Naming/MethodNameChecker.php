<?php

namespace Inspector\Analysis\Checker\Naming;

use PhpParser\Node;
use Inspector\Application\Exception\Exception;
use Inspector\Analysis\Checker\CheckerInterface;
use Inspector\Analysis\Exception\AnalysisException;


/**
 * @author Kabir Baidhya
 */
class MethodNameChecker implements CheckerInterface
{

    /**
     * Checks to make sure the classes, methods, and functions are up to the standards
     * and don't use bad practices
     *
     * @param Node $node
     * @throws Exception
     * @throws AnalysisException
     */
    public function check(Node $node)
    {

    }
}
