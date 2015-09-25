<?php

namespace Inspector\Analysis\Exception;


class GotoDetectedException extends AnalysisException
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
