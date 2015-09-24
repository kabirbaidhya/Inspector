<?php

namespace Inspector\Analysis\Result;

/**
 * @author Kabir Baidhya
 */
class Result implements ResultInterface
{

    /**
     * @var string
     */
    protected $filename;

    /**
     * @var array
     */
    protected $issues;

    public function __construct($filename, array $issues)
    {
        $this->filename = $filename;
        $this->issues = $issues;
    }

    /**
     * Returns the analyzed file name
     *
     * @return string
     */
    public function getFilename()
    {
        return $this->filename;
    }

    /**
     * @return array
     */
    public function getMessages()
    {
        return $this->issues;
    }

    /**
     * Calculates the Quality index of an analyzed file.
     *
     * @return int
     */
    public function getQuality()
    {
        $issueCount = count($this->issues);

        if ($issueCount === 0) {
            return 4;
        } elseif ($issueCount <= 2) {
            return 3;
        } elseif ($issueCount <= 5) {
            return 2;
        } else {
            return 1;
        }
    }

    /**
     * Returns the quality rating text for to be displayed in the feedback.
     *
     * @return string
     */
    public function getQualityRating()
    {
        $ratings = [
            4 => 'A',
            3 => 'B',
            2 => 'C',
            1 => 'D'
        ];

        return $ratings[$this->getQuality()];
    }
}
