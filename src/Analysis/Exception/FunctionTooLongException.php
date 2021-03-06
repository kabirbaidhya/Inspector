<?php

namespace Inspector\Analysis\Exception;


class FunctionTooLongException extends AnalysisException
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
