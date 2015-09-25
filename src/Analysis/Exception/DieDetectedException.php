<?php

namespace Inspector\Analysis\Exception;


class DieDetectedException extends AnalysisException
{

    /**
     * Returns params for the message.
     *
     * @return array
     */
    public function getMessageParams()
    {
        return [$this->getLineNumber()];
    }
}
