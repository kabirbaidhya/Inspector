<?php

namespace Analyzer\Console\Commands;

use Analyzer\Application;
use Analyzer\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class InitCommand extends Command
{
    protected $name = 'init';

    protected $description = 'Initializes & generates an config file';

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int|null|void
     * @throws \Exception
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        /** @var FileSystem $fileSystem */
        $fileSystem = $this->getContainer()->make('filesystem');

        $sourceFile = __DIR__ . '/../../../' . Application::APP_DEFAULT_CONFIG . '.dist';
        $destinationFile = getcwd() . '/' . Application::APP_DEFAULT_CONFIG;

        if ($fileSystem->exists($destinationFile)) {
            throw new \Exception('Config file has already been initialized.');
        }

        $fileSystem->copy($sourceFile, $destinationFile);

        $output->writeln('<comment>Config file generated at:</comment> ' . $destinationFile);
    }
}
