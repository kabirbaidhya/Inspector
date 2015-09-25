<?php
return [
    // Lines of Code
    'MethodTooLong' => 'Method <code>%s</code> is too long. ',
    'FunctionTooLong' => 'Function <code>%s</code> is too long. ',
    'ClassTooLong' => 'Class <code>%s</code> is very long. ',
    // Complexity
    'MethodTooComplex' => 'Method <code>%s</code> is very complex. ',
    'FunctionTooComplex' => 'Function <code>%s</code> is too complex. ',
    'ClassTooComplex' => 'Class <code>%s</code> is very complex. ',
    //Eval
    'EvalDetected' => 'Use of <code>eval()</code> detected at line %s. \nEval language construct is very dangerous as it allows  execution of arbitrary PHP code. Its usage is strongly discouraged.',
    // die() or exit()
    'DieDetected' => 'Use of <code>die()</code> or <code>exit()</code> detected at line %s. Relying on these language constructs for error handling suggests a poorly designed system, as there are better ways to do it(eg: <code>Exceptions</code>). ',
    'GotoDetected' => 'Use of <code>goto</code> detected at line %s. It is a bad practice to use them. '
];
