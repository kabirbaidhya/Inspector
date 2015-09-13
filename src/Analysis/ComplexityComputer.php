<?php

namespace Analyzer\Analysis;

/**
 * Computes the Cyclomatic complexity of a method/function
 * @author Kabir Baidhya
 *
 */
class ComplexityComputer implements AnalyzerInterface
{

    public function analyze($ast)
    {
        dd($ast);
    }
}
