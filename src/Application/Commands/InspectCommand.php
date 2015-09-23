<?php

namespace Inspector\Application\Commands;

use Inspector\Application\Command;
use Symfony\Component\Console\Input\InputArgument;
use Inspector\Application\Service\AnalyzerService;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class InspectCommand extends Command
{

    protected $name = 'inspect';

    protected $description = 'Inspects and analyzes the source code';

    /**
     * @var AnalyzerService
     */
    protected $analyzerService;

    /**
     * @param AnalyzerService $analyzerService
     */
    public function __construct(AnalyzerService $analyzerService)
    {
        parent::__construct();

        $this->analyzerService = $analyzerService;
    }

    /**
     * @return array
     */
    protected function getArguments()
    {
        return [
            ['path', InputArgument::REQUIRED, 'Source path to inspect']
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

        $feedback = $this->analyzerService->analyze($path, $options);

        $output->writeln('FeedBack');

        $output->write($feedback);
    }

}
