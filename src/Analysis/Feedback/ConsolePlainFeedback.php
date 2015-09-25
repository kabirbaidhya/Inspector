<?php

namespace Inspector\Analysis\Feedback;

use PhpParser\Node;
use Inspector\Analysis\Result\AnalysisResult;
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
     * @param array $params
     * @return string
     */
    public function generate(AnalysisResult $result, array $params)
    {
        $this->output->writeln(
            "\n" . sprintf('<info>Code Rating:</info> %s', $result->getRatingDescription())
        );

        $fileIndex = 1;
        foreach ($result->getFiles() as $filename => $file) {

            $relativePath = $file->getRelativeFilename($params['basePath']);
            $this->output->writeln(
                sprintf(
                    "\n<comment>File #%d.</comment> %s <question> %s </question>", $fileIndex, $relativePath,
                    $file->getQualityRating()
                ) . ($file->isOkay() ? ' - OK' : '')
            );
            $index = 1;
            foreach ($file->getIssues() as $issue) {

                $this->output->writeln(
                    sprintf(' Issue %d: %s', $index, strip_tags($issue->getMessage()))
                );
                $index++;
            }
            $fileIndex++;
        }
    }

}
