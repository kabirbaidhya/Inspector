<?php
/**
 * Created by PhpStorm.
 * User: kabir
 * Date: 9/16/15
 * Time: 6:21 PM
 */

namespace Analyzer\Analysis\FlawDetection;

use Analyzer\Application\Exception\Exception;

interface CheckerInterface
{

    /**
     * Checks to make sure the classes, methods, and functions are not
     * very long on the basis of Lines of Code
     *
     * @param Node[]|null $ast
     * @return bool
     * @throws Exception
     */
    public function check($ast);
}
