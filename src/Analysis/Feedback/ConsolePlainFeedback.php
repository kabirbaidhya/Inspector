<?php

namespace Inspector\Analysis\Feedback;

use PhpParser\Node;
use Inspector\Analysis\Result\AnalysisResult;
use Inspector\Analysis\Exception\AnalysisException;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * @author Kabir Baidhya
 */
class ConsolePlainFeedback implements FeedbackInterface
{

    /**
     * @var array
     */
    protected $config;

    /**
     * @var OutputInterface
     */
    protected $output;

    /**
     * @param array $config
     * @param OutputInterface $output
     */
    public function __construct(array $config, OutputInterface $output)
    {
        $this->config = $config;
        $this->output = $output;
    }

    /**
     * Generates the feedback.
     *
     * @param AnalysisResult $result
     * @return string
     */
    public function generate(AnalysisResult $result)
    {
        $this->output->writeln(sprintf("\n<info>Inspection of:</info> %s\n", $result->getBasePath()));
        $this->output->writeln(
            sprintf('<info>Code Rating:</info> %s out of %s <comment>[%s]</comment>', $result->getCodeRating(),
                AnalysisResult::MAX_CODE_RATING, $result->getRatingText())
        );

        $fileIndex = 1;
        foreach ($result->getFiles() as $filename => $file) {
            $this->output->writeln(
                sprintf("\n<comment>File #%d. %s</comment> <question> %s </question>", $fileIndex, $filename,
                    $file->getQualityRating()) .
                ($file->isOkay() ? ' - OK' : '')
            );
            $index = 1;
            foreach ($file->getIssues() as $issue) {

                $rawMessage = $this->getMessage($issue);

                $this->output->writeln(
                    sprintf(' Issue %d: %s %s', $index, $rawMessage, $this->getLineInfo($issue))
                );
                $index++;
            }
            $fileIndex++;
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
     * @param AnalysisException $exception
     * @return string
     */
    protected function getLineInfo(AnalysisException $exception)
    {
        $line = $exception->getLineNumber();
        $lineInfo = is_int($line) ? ' at line ' . $line : ' from line ' . $line[0] . ' to ' . $line[1];

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
