<?php

namespace Inspector\Test\Foundation;

use Inspector\Test\TestCase;
use Inspector\Foundation\ClassHelper;

/**
 * @author Kabir Baidhya
 */
class ClassHelperTest extends TestCase
{

    protected $classHelper;

    public function _before()
    {
        $this->classHelper = new ClassHelper();
    }

    /**
     * @dataProvider classNamesProvider
     */
    public function testItShortensFullyQualifiedClassNames($fullName, $shortName)
    {
        $result = $this->classHelper->shorten($fullName);
        $this->assertEquals($shortName, $result);
    }

    public function testItReturnsSameThingIfNotANamespacedClass()
    {
        $result = $this->classHelper->shorten('HelloWorld');
        $this->assertEquals('HelloWorld', $result);
    }

    public function classNamesProvider()
    {
        return [
            ['Inspector\Analysis\FlawDetection\DieDetector', 'DieDetector'],
            ['Inspector\Analysis\FlawDetection\GotoDetector', 'GotoDetector'],
            ['Inspector\Analysis\FlawDetection\EvalDetector', 'EvalDetector'],
            ['Inspector\Analysis\FlawDetection\LinesOfCodeChecker', 'LinesOfCodeChecker'],
            ['Inspector\Analysis\FlawDetection\ClassComplexityChecker', 'ClassComplexityChecker'],
            ['Inspector\Analysis\FlawDetection\MethodComplexityChecker', 'MethodComplexityChecker'],
            ['Inspector\Analysis\FlawDetection\FunctionComplexityChecker', 'FunctionComplexityChecker'],
        ];
    }
}
