<?php
return [
    // Lines of Code
    'MethodTooLong' => 'Method %s is too long. ',
    'FunctionTooLong' => 'Function %s is too long. ',
    'ClassTooLong' => 'Class %s is very long. ',
    // Complexity
    'MethodTooComplex' => 'Method %s is very complex. (CCN = %s)',
    'FunctionTooComplex' => 'Function %s is too complex. (CCN = %s)',
    'ClassTooComplex' => 'Class %s is very complex. (CCN = %s)',
    //Eval
    'EvalDetected' => 'Use of eval() detected at line %s. \nEval language construct is very dangerous as it allows  execution of arbitrary PHP code. Its usage is strongly discouraged.',
    // die() or exit()
    'DieDetected' => 'Use of die() or exit() detected at line %s. \nRelying on these language constructs for error handling suggests a poorly designed system, as there are better ways to do it(eg: Exceptions). ',
    'GotoDetected' => 'Use of goto detected at line %s. It is a bad practice to use them. '
];
