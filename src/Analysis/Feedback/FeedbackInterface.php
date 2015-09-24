<?php

namespace Inspector\Analysis\Feedback;

use Inspector\Analysis\Result\ResultInterface;

interface FeedbackInterface
{

    /**
     * Generates the feedback.
     *
     * @param ResultInterface[] $results List of the Results for each analyzed file
     * @return string
     */
    public function generate(array $results);
}
