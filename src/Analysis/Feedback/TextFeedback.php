<?php

namespace Inspector\Analysis\Feedback;

use Inspector\Analysis\Exception\AnalysisException;
use Inspector\Analysis\Result\ResultInterface;
use PhpParser\Node;

/**
 * @author Kabir Baidhya
 */
class TextFeedback implements FeedbackInterface
{

    /**
     * @var array
     */
    private $config;

    /**
     * @param array $config
     */
    public function __construct(array $config)
    {
        $this->config = $config;
    }

    /**
     * Generates the feedback.
     *
     * @param ResultInterface[] $feedback List of the analyzed Result
     * @return string
     */
    public function generate(array $feedback)
    {
        foreach ($feedback as $filename => $result) {
            dump(sprintf('File: %s  Rating: %s', $filename, $result->getQualityRating()));
            $index = 1;
            foreach ($result->getMessages() as $error) {

                $rawMessage = $this->getMessage($error);

                printf("Issue %d: %s %s\n\n", $index, $rawMessage, $this->getLineInfo($error->getNode()));
                $index++;
            }
            if (empty($messages)) {
                dump('Code is okay.');
            }
        }
    }

    /**
     * @param AnalysisException $exception
     * @return string
     */
    protected function getMessage(AnalysisException $exception)
    {
        $key = $this->getMessageKey($exception);
        $messages = $this->config['messages'];
        $message = isset($messages[$key]) ? $messages[$key] : $key;

        return $message;
    }

    /**
     * Returns the line information.
     *
     * @param Node $node
     * @return string
     */
    protected function getLineInfo(Node $node)
    {
        $startLine = $node->getAttribute('startLine');
        $endLine = $node->getAttribute('endLine');

        $lineInfo = ($startLine == $endLine) ? ' at line ' . $startLine : ' from line ' . $startLine . ' to ' . $endLine;

        return $lineInfo;
    }

    /**
     * @param AnalysisException $exception
     * @return string
     */
    protected function getMessageKey(AnalysisException $exception)
    {
        $identifier = str_replace('Exception', '', get_class($exception));
        $identifier = str_replace('Inspector\\Analysis\\\\', '', $identifier);

        return $identifier;
    }
}
