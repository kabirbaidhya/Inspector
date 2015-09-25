<?php

namespace Inspector\Analysis\Exception;

class MethodTooComplexException extends AnalysisException
{

    /**
     * Returns params for the message.
     *
     * @return array
     */
    public function getMessageParams()
    {
        return [$this->getNode()->name, self::calculateCCN($this->getNode())];
    }
}
