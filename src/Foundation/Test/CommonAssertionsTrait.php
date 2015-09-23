<?php

namespace Inspector\Foundation\Test;

use PHPUnit_Framework_ExpectationFailedException;

/**
 * @author Kabir Baidhya
 */
trait CommonAssertionsTrait
{

    /**
     * Asserts to make sure an array is an array of instances of the provided class.
     *
     * @param string $expectedClass The fully-qualified classname
     * @param array $array
     * @throws PHPUnit_Framework_ExpectationFailedException
     */
    protected function assertArrayOf($expectedClass, array $array)
    {
        foreach ($array as $item) {
            $assert = (is_a($item, $expectedClass));
            if ($assert === false) {
                throw new PHPUnit_Framework_ExpectationFailedException(
                    sprintf(
                        'Failed asserting that the the given array is an array of instances of \'%s\'.',
                        $expectedClass
                    )
                );
            }
        }
    }
}
