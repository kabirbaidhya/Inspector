<?php

/**
 * Usage of goto statement
 */
function example()
{
    if ($a == $b) {
        if ($a1 == $b1) {
            fiddle();
        } else {
            if ($a2 == $b2) {
                fiddle();
            } else {
//                goto b;
            }
        }
    } elseif ($a == $b) {
        if ($a1 == $b1) {
            fiddle();
        } else {
            if ($a2 == $b2) {
                fiddle();
            } else {
                goto b;
            }
        }
    }
    eval('echo "hello";');
    eval('echo "hello";');
    eval('echo "hello";');
    eval('echo "hello";');
}

// demonstration of goto statement
b:
die();
