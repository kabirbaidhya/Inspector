<?php

namespace Inspector\Foundation;

/**
 * @author Kabir Baidhya
 */
class ClassHelper
{

    /**
     * Gets a short class name from a fully qualified class name
     *
     * @param $className
     * @return string
     */
    public function shorten($className)
    {
        // last index of backslash '\'
        $index = strrpos($className, '\\');

        return ($index === false) ? $className : substr($className, $index + 1);
    }
}
