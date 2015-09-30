<?php

return [
    // Bad Practice Checkers
    'Inspector\Analysis\Checker\BadPractice\DieDetector',
    'Inspector\Analysis\Checker\BadPractice\GotoDetector',
    'Inspector\Analysis\Checker\BadPractice\EvalDetector',
    // Miscellaneous Checkers
    'Inspector\Analysis\Checker\Misc\LinesOfCodeChecker',
    'Inspector\Analysis\Checker\Misc\ClassPerFileChecker',
    // Complexity Checkers
    'Inspector\Analysis\Checker\Complexity\ClassComplexityChecker',
    'Inspector\Analysis\Checker\Complexity\MethodComplexityChecker',
    'Inspector\Analysis\Checker\Complexity\FunctionComplexityChecker',
    // Naming Inconsistencies Checkers
    'Inspector\Analysis\Checker\Naming\ClassNameChecker',
    'Inspector\Analysis\Checker\Naming\MethodNameChecker',
    'Inspector\Analysis\Checker\Naming\FunctionNameChecker',
];
