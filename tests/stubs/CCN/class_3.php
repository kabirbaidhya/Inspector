<?php

class ASampleClassWithRefactoredMethod
{

    private function _countCalls(PHP_Depend_Code_AbstractCallable $callable)
    {
        $called = [];

        $tokens = $callable->getTokens();
        $count = count($tokens);
        for ($i = $this->_findOpenCurlyBrace($tokens); $i < $count; ++$i) {

            if ($this->_isCallableOpenParenthesis($tokens, $i) === false) {
                continue;
            }

            if ($this->_isMethodInvocation($tokens, $i) === true) {
                $image = $this->_getInvocationChainImage($tokens, $i);
            } else {
                if ($this->_isFunctionInvocation($tokens, $i) === true) {
                    $image = $tokens[$i - 1]->image;
                } else {
                    $image = null;
                }
            }

            if ($image !== null) {
                $called[$image] = $image;
            }
        }

        $this->_calls += count($called);
    }
}


