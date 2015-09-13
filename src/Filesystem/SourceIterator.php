<?php

namespace Analyzer\Filesystem;

use Iterator;

/**
 * @author Kabir Baidhya
 */
class SourceIterator implements Iterator
{

    /**
     * @var Iterator
     */
    protected $fileIterator;

    /**
     * @var ReaderInterface
     */
    protected $reader;

    /**
     * @param Iterator $fileIterator
     * @param ReaderInterface $reader
     */
    public function __construct(Iterator $fileIterator, ReaderInterface $reader)
    {
        $this->fileIterator = $fileIterator;
        $this->reader = $reader;
    }

    /**
     * Returns the source code of current source file
     *
     * @return SourceCode
     */
    public function current()
    {
        $filename = $this->fileIterator->current();

        return $this->reader->read($filename);
    }

    /**
     * @return void Any returned value is ignored.
     */
    public function next()
    {
        $this->fileIterator->next();
    }

    /**
     * Returns the filename
     * @return string scalar on success, or null on failure.
     */
    public function key()
    {
        return $this->fileIterator->key();
    }

    /**
     * @return boolean The return value will be casted to boolean and then evaluated.
     * Returns true on success or false on failure.
     */
    public function valid()
    {
        return $this->fileIterator->valid();
    }

    public function rewind()
    {
        $this->fileIterator->rewind();
    }

}
