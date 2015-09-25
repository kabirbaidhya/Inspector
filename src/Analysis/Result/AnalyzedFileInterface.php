<?php


namespace Inspector\Analysis\Result;


/**
 * @author Kabir Baidhya
 */
interface AnalyzedFileInterface
{

    /**
     * Returns the analyzed file name
     *
     * @return string
     */
    public function getFilename();

    /**
     * @return array
     */
    public function getIssues();

    /**
     * @return int
     */
    public function getIssueCount();

    /**
     * Calculates the (Numeric) Quality index of an analyzed file.
     *
     * @return int
     */
    public function getQuality();

    /**
     * Returns the quality rating text for to be displayed in the feedback.
     *
     * @return string
     */
    public function getQualityRating();

    /**
     * @return bool
     */
    public function isOkay();
}
