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
                goto b;
            }
        }
    } else {
        if ($c == $d) {
            while ($c == $d) {
                goto b;
            }
        } else {
            if ($e == $f) {
                for ($n = 0; $n < $h; $n++) {
                    exit();
                }
            }
        }
    }
    eval('echo "hello";');
}

// demonstration of goto statement
b:
die();
