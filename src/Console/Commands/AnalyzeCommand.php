<?php

namespace Analyzer\Console\Commands;

use Analyzer\Console\Command;
use Analyzer\Analysis\Analyzer;
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
    protected $analyzer;

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
        dump($feedback);
    }

}
