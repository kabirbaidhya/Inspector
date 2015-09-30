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
     * @param AnalyzedFile[] $analyzedFiles
     */
    public function __construct(array $analyzedFiles)
    {
        $this->analyzedFiles = $analyzedFiles;
    }

    public function getCodeRating()
    {
        $totalRating = 0;
        foreach ($this->analyzedFiles as $file) {
            $totalRating += $file->getQuality();
        }

        $totalFiles = $this->countFiles();

        $rating = number_format(($totalFiles === 0) ? 0 : (($totalRating / $totalFiles) / self::MAX_CODE_RATING_FILE) * self::MAX_CODE_RATING,
            2);

        return $rating;
    }

    public function countFiles()
    {
        return count($this->analyzedFiles);
    }

    public function getRatingText()
    {
        $ratingText = [
            0 => 'No Rating',
            1 => 'Very Bad',
            2 => 'Very Bad',
            3 => 'Very Good',
            4 => 'Bad',
            5 => 'Moderate',
            6 => 'Not Bad',
            8 => 'Good',
            7 => 'Very Good',
            9 => 'Very Good',
            10 => 'Awesome',
        ];
        $rating = (int)floor($this->getCodeRating());

        return $ratingText[$rating];
    }

    /**
     * @return string
     */
    public function getRatingDescription()
    {
        return sprintf('%s out of 10 - %s', $this->getCodeRating(), $this->getRatingText());
    }

    /**
     * @return int
     */
    public function countIssues()
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

}
