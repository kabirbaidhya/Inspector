<?php

class ASampleClassWithComplexMethod
{

    private function _countCalls(PHP_Depend_Code_AbstractCallable $callable)
    {
        $callT = [
            \PDepend\Source\Tokenizer\Tokens::T_STRING,
            \PDepend\Source\Tokenizer\Tokens::T_VARIABLE
        ];
        $chainT = [
            \PDepend\Source\Tokenizer\Tokens::T_DOUBLE_COLON,
            \PDepend\Source\Tokenizer\Tokens::T_OBJECT_OPERATOR,
        ];

        $called = [];

        $tokens = $callable->getTokens();
        $count = count($tokens);
        for ($i = 0; $i < $count; ++$i) {
            // break on function body open
            if ($tokens[$i]->type === \PDepend\Source\Tokenizer\Tokens::T_CURLY_BRACE_OPEN) {
                break;
            }
        }

        for (; $i < $count; ++$i) {
            // Skip non parenthesis tokens
            if ($tokens[$i]->type !== \PDepend\Source\Tokenizer\Tokens::T_PARENTHESIS_OPEN) {
                continue;
            }
            // Skip first token
            if (!isset($tokens[$i - 1]) || !in_array($tokens[$i - 1]->type, $callT)) {
                continue;
            }
            // Count if no other token exists
            if (!isset($tokens[$i - 2]) && !isset($called[$tokens[$i - 1]->image])) {
                $called[$tokens[$i - 1]->image] = true;
                ++$this->_calls;
                continue;
            } else {
                if (in_array($tokens[$i - 2]->type, $chainT)) {
                    $identifier = $tokens[$i - 2]->image . $tokens[$i - 1]->image;
                    for ($j = $i - 3; $j >= 0; --$j) {
                        if (!in_array($tokens[$j]->type, $callT)
                            && !in_array($tokens[$j]->type, $chainT)
                        ) {
                            break;
                        }
                        $identifier = $tokens[$j]->image . $identifier;
                    }

                    if (!isset($called[$identifier])) {
                        $called[$identifier] = true;
                        ++$this->_calls;
                    }
                } else {
                    if ($tokens[$i - 2]->type !== \PDepend\Source\Tokenizer\Tokens::T_NEW
                        && !isset($called[$tokens[$i - 1]->image])
                    ) {
                        $called[$tokens[$i - 1]->image] = true;
                        ++$this->_calls;
                    }
                }
            }
        }
    }
}


