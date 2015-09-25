<?php

namespace Inspector\Analysis\Result;

use Inspector\Analysis\Exception\AnalysisException;

/**
 * @author Kabir Baidhya
 */
class Issue
{

    /**
     * @var AnalysisException
     */
    protected $exception;

    protected $message;

    /**
     * @param AnalysisException $exception
     * @param $message
     */
    public function __construct(AnalysisException $exception, $message)
    {
        $this->exception = $exception;
        $this->message = $message;
    }

    public function getMessage()
    {
        return $this->message;
    }

    public function getStartLine()
    {
        return $this->getNode()->getAttribute('startLine');
    }

    public function getNode()
    {
        return $this->exception->getNode();
    }

    public function getEndLine()
    {
        return $this->getNode()->getAttribute('endLine');
    }
}
