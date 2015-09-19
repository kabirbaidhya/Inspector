<?php


namespace Inspector\Filesystem;

use Illuminate\Filesystem\Filesystem;

/**
 *
 * @author Kabir Baidhya
 */
class Reader implements ReaderInterface
{

    /**
     * @var Filesystem
     */
    protected $filesystem;

    /**
     * @param Filesystem $filesystem
     */
    public function __construct(Filesystem $filesystem)
    {
        $this->filesystem = $filesystem;
    }

    /**
     * Reads a file to return the source code.
     *
     * @param string $path
     * @return SourceCode
     */
    public function read($path)
    {
        $code = $this->filesystem->get($path);

        return new SourceCode($code);
    }

}
