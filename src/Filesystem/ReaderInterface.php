<?php


namespace Analyzer\Filesystem;

/**
 *
 * @author Kabir Baidhya
 */
interface ReaderInterface
{

    /**
     * Reads a file to return the source code.
     *
     * @param string $path
     * @return SourceCode
     */
    public function read($path);
}
