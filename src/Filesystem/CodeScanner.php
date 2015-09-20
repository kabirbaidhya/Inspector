<?php

namespace Inspector\Filesystem;

use RegexIterator;
use RuntimeException;
use RecursiveIteratorIterator;
use RecursiveDirectoryIterator;
use Illuminate\Filesystem\Filesystem;

class CodeScanner
{

    /**
     * @var Filesystem
     */
    protected $fs;

    const SOURCE_FILE_EXTENSION = '/\.php$/';

    /**
     * @param Filesystem $fs
     */
    public function __construct(Filesystem $fs)
    {
        $this->fs = $fs;
    }

    /**
     * Scans a directory
     *
     * @param string $path
     * @return SourceIterator
     */
    public function scan($path)
    {
        if ($this->fs->isDirectory($path)) {

            $iterator = $this->getSourceIterator($path, self::SOURCE_FILE_EXTENSION);

        } elseif ($this->fs->isFile($path)) {

            $filename = $this->getFilePattern($path);
            $path = dirname($path);

            $iterator = $this->getSourceIterator($path, $filename);
        } else {

            throw new RuntimeException(sprintf('Path not found: %s', $path));
        }

        return new SourceIterator($iterator, new Reader($this->fs));
    }

    /**
     * @param string $path
     * @param string $pattern
     * @return RecursiveDirectoryIterator
     */
    protected function getSourceIterator($path, $pattern)
    {
        $iterator = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($path)
        );

        $fileIterator = new RegexIterator($iterator, $pattern);

        return $fileIterator;
    }

    /**
     * @param string $path
     * @return string
     */
    protected function getFilePattern($path)
    {
        $filename = '/' . basename($path) . '$/';

        return $filename;
    }

}
