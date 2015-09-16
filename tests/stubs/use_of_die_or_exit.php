<?php

/**
 * Usage of die() or exit()
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
                die();
            }
        }
    } else {
        if ($c == $d) {
            while ($c == $d) {
                fiddle();
            }
        } else {
            if ($e == $f) {
                for ($n = 0; $n < $h; $n++) {
                    exit();
                }
            }
        }
    }
}
