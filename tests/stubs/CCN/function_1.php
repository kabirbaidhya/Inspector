<?php

/**
 * Just a test function for calculating its CCN value
 * @author Kabir
 */

function example($x, $y)
{
    if ($x > 23 || $y < 42) {
        $func = function ($b) {
            return $b;
        };
        for ($i = $x; $i >= $x && $i <= $y; ++$i) {

        }
    } else {
        switch ($x + $y) {
            case 1:
                break;
            case 2:
                break;
            default:
                break;
        }
    }
    file_exists('/tmp/log') or touch('/tmp/log');
}
