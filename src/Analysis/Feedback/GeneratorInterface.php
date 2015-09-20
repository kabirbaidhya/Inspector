<?php

namespace Inspector\Analysis\Output;


use Inspector\Analysis\Exception\AnalysisException;

interface GeneratorInterface
{

    /**
     * Generates the feedback.
     *
     * @param array|AnalysisException[] $feedback List of the error messages
     * @return string
     */
    public function generate(array $feedback);
}
