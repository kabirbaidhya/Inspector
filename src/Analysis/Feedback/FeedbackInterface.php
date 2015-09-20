<?php

namespace Inspector\Analysis\Feedback;

interface FeedbackInterface
{

    /**
     * Generates the feedback.
     *
     * @param array $feedback List of the error messages for each file
     * @return string
     */
    public function generate(array $feedback);
}
