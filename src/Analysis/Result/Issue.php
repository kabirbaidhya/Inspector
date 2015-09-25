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

    /**
     * @param AnalysisException $exception
     */
    public function __construct(AnalysisException $exception)
    {
        $this->exception = $exception;
    }

    public function getMessage()
    {

    }

    public function getCodePart()
    {

    }
}
