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

    public function getCodePart()
    {
        //todo
    }

    public function startingLine()
    {
        return $this->exception->getStartLine();
    }
}
