<?php

namespace Inspector\Analysis\Exception;


class FunctionTooComplexException extends AnalysisException
{

    /**
     * Returns params for the message.
     *
     * @return array
     */
    public function getMessageParams()
    {
        return [$this->getNode()->name];
    }
}
