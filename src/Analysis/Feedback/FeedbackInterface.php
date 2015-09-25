<?php

namespace Inspector\Analysis\Feedback;

use Inspector\Analysis\Result\AnalysisResult;
use Inspector\Analysis\Result\ResultInterface;

interface FeedbackInterface
{

    /**
     * Generates the feedback.
     *
     * @param AnalysisResult $result
     * @return string
     */
    public function generate(AnalysisResult $result);
}
