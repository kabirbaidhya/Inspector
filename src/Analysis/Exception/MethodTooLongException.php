<?php

namespace Inspector\Analysis\Exception;


class MethodTooLongException extends AnalysisException
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
