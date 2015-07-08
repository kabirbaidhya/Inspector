<?php

namespace Analyzer\Console\Commands;

use Analyzer\Console\Command;
use Analyzer\Generator\Mapper;
use Illuminate\Filesystem\Filesystem;
use Analyzer\Generator\FormGeneratorInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class AnalyzeCommand extends Command
{

    protected $name = 'analyze';
    protected $description = 'Analyzes the source code';

    protected function getArguments()
    {
        return [
        ];
    }

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

    }

}
