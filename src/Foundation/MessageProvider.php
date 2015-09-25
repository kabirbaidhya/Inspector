<?php

namespace Inspector\Foundation;

use RuntimeException;
use Inspector\Analysis\Result\Issue;
use Inspector\Analysis\Exception\AnalysisException;

/**
 * @author Kabir Baidhya
 */
class MessageProvider
{

    /**
     * @var array
     */
    protected $messages;

    public function __construct(array $config)
    {
        $this->messages = $config['messages'];
    }

    /**
     * Gets a message for a key.
     *
     * @param string $key
     * @param array $params
     * @return string
     */
    public function getMessage($key, array $params)
    {
        if (!isset($this->messages[$key])) {
            throw new RuntimeException(
                sprintf('Message for %s not found. ', $key)
            );
        }

        $rawMessage = $this->messages[$key];

        return vsprintf($rawMessage, $params);
    }

    /**
     * Translates an array of AnalysisException instances to array of Issue
     *
     * @param AnalysisException[] $exceptions
     * @return Issue[]
     */
    public function translateExceptions(array $exceptions)
    {
        $classHelper = new ClassHelper();
        $issues = [];
        foreach ($exceptions as $exception) {
            $key = str_replace('Exception', '', $classHelper->shorten(get_class($exception)));

            $message = $this->getMessage($key, $exception->getMessageParams());
            $issues[] = new Issue($exception, $message);
        }

        return $issues;
    }
}
