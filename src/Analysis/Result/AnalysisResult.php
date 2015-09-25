<?php

namespace Inspector\Analysis\Result;

/**
 * @author Kabir Baidhya
 */
class AnalysisResult
{

    const MAX_CODE_RATING = 10;

    const MAX_CODE_RATING_FILE = 4;

    /**
     * @var AnalyzedFile[]
     */
    protected $analyzedFiles;

    /**
     * @var string
     */
    protected $basePath;

    /**
     * @param string $basePath
     * @param AnalyzedFile[] $analyzedFiles
     */
    public function __construct($basePath, array $analyzedFiles)
    {
        $this->analyzedFiles = $analyzedFiles;
        $this->basePath = $basePath;
    }

    public function getCodeRating()
    {
        $totalRating = 0;
        foreach ($this->analyzedFiles as $file) {
            $totalRating += $file->getQuality();
        }

        $totalFiles = $this->totalFiles();

        $rating = number_format(($totalFiles === 0) ? 0 : (($totalRating / $totalFiles) / self::MAX_CODE_RATING_FILE) * self::MAX_CODE_RATING,
            2);

        return $rating;
    }

    public function totalFiles()
    {
        return count($this->analyzedFiles);
    }

    public function getRatingText()
    {
        $ratingText = [
            0 => 'No Rating',
            1 => 'Good',
            2 => 'Very Good',
            3 => 'Very Good',
            4 => 'Very Good',
            5 => 'Very Good',
            6 => 'Very Good',
            7 => 'Very Good',
            8 => 'Very Good',
            9 => 'Very Good',
            10 => 'Very Good',
        ];
        $rating = floor($this->getCodeRating());

        return $ratingText[$rating];
    }

    /**
     * @return int
     */
    public function getTotalIssues()
    {
        $issueCount = 0;
        foreach ($this->getFiles() as $file) {
            $issueCount += $file->getIssueCount();
        }

        return $issueCount;
    }

    /**
     * @return array|AnalyzedFile[]
     */
    public function getFiles()
    {
        return $this->analyzedFiles;
    }

    /**
     * @return string
     */
    public function getBasePath()
    {
        return $this->basePath;
    }

}
