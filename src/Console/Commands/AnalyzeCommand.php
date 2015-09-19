<?php

namespace Inspector\Console\Commands;

use Inspector\Console\Command;
use Inspector\Analysis\Analyzer;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class AnalyzeCommand extends Command
{

    protected $name = 'analyze';

    protected $description = 'Analyzes the source code';

    /**
     * @var Analyzer
     */
    private $analyzer;

    /**
     * @param Analyzer $analyzer
     */
    public function __construct(Analyzer $analyzer)
    {
        parent::__construct();

        $this->analyzer = $analyzer;
    }

    /**
     * @return array
     */
    protected function getArguments()
    {
        return [
            ['path', InputArgument::REQUIRED, 'Source path to analyze']
        ];
    }

    /**
     * @return array
     */
    protected function getOptions()
    {
        return [

        ];
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int|null|void
     * @throws \Exception
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $path = $input->getArgument('path');
        $options = $input->getOptions();

        $feedback = $this->analyzer->analyze($path, $options);

        $output->writeln('FeedBack');

        $index = 1;
        foreach ($feedback as $error) {

            $identifier = str_replace('Exception', '', get_class($error));
            $identifier = str_replace('Inspector\\Analysis\\\\', '', $identifier);
            $node = $error->getNode();
            $startLine = $node->getAttribute('startLine');
            $endLine = $node->getAttribute('endLine');

            $lineInfo = ($startLine == $endLine) ? ' at line ' . $startLine : ' from line ' . $startLine . ' to ' . $endLine;
            printf("Issue %d: %s %s\n", $index, $identifier, $lineInfo);
            $index++;
        }
        if (empty($feedback)) {
            dump('Code is okay.');
        }
//        dump($feedback);
    }

}
