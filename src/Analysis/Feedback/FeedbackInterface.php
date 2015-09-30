<?php

namespace Inspector\Analysis\Feedback;

use Inspector\Analysis\Result\AnalysisResult;

interface FeedbackInterface
{

    /**
     * Generates the feedback.
     *
     * @param AnalysisResult $result
     * @param array $params Additional data for generating the feedback
     * @return string
     */
    public function generate(AnalysisResult $result, array $params);
}
