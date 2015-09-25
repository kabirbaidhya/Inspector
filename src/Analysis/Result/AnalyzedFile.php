<?php

namespace Inspector\Analysis\Result;

use InvalidArgumentException;


/**
 * @author Kabir Baidhya
 */
class AnalyzedFile implements AnalyzedFileInterface
{

    const EXTRA_VISIBLE_LINES = 3;

    /**
     * @var string
     */
    protected $filename;

    /**
     * @var array
     */
    protected $issues;

    protected $code;

    protected $linesOfCode;

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

    /**
     * @return array
     */
    public function getIssues()
    {
        return $this->issues;
    }

    /**
     * @return int
     */
    public function getIssueCount()
    {
        return count($this->issues);
    }

    /**
     * @return bool
     */
    public function isOkay()
    {
        return ($this->getIssueCount() === 0);
    }

    public function getIssueCodeStartLine(Issue $issue, $includeExtra = true)
    {
        $startLine = $issue->getStartLine();

        if ($includeExtra) {
            $startLine = $startLine - self::EXTRA_VISIBLE_LINES;
            if ($startLine < 1) {
                $startLine = 1;
            }
        }

        return $startLine;
    }

    /**
     * Get code part contained by the $startLine & the $endLine numbers
     * Also includes some extra lines($extraLines) before $startLine and after $endLine
     *
     * @param $startLine
     * @param $endLine
     * @return string
     */
    public function getCodePart($startLine, $endLine)
    {
        $extraLines = self::EXTRA_VISIBLE_LINES;
        if ($endLine < $startLine) {
            throw new InvalidArgumentException('End line should be come after the start line');
        }

        if (!$this->linesOfCode) {
            $this->linesOfCode = explode("\n", $this->getCode());
        }

        $offset = ($startLine - 1 - $extraLines);

        if ($offset < 0) {
            $offset = 0;
        }

        $noOfLines = ($endLine - $startLine) + 2 * $extraLines;
        $slicedLines = array_slice($this->linesOfCode, $offset, $noOfLines);

        return implode("\n", $slicedLines);
    }

    /**
     * Get the code for an issue.
     *
     * @param Issue $issue
     * @return string
     */
    public function getCodeForIssue(Issue $issue)
    {
        $startLine = $issue->getStartLine();
        $endLine = $issue->getEndLine();

        return $this->getCodePart($startLine, $endLine);
    }

    /**
     * @return string
     */
    public function getCode()
    {
        if (!$this->code) {
            $this->code = file_get_contents($this->getFilename());
        }

        // Remove the php delimiter as it causes trouble for code rendering
        return str_ireplace('<?php', '', $this->code);
    }
}
