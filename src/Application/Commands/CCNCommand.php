<?php

namespace Inspector\Application\Commands;

use PhpParser\Parser;
use Inspector\Application\Command;
use Illuminate\Filesystem\Filesystem;
use Inspector\Filesystem\SourceReader;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CCNCommand extends Command
{

    protected $name = 'ccn';

    protected $description = 'Computes the Cyclomatic Complexity of the code';

    protected function getArguments()
    {
        return [
            [
                'path',
                InputArgument::REQUIRED,
                'Path to the source file(s)'
            ]
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

        /** @var SourceReader $reader */
        $reader = $this->getContainer()->make('source-reader');

        /** @var Parser $parser */
        $parser = $this->getContainer()->make('parser');

        /** @var Filesystem $fs */
        $fs = $this->getContainer()->make('filesystem');

        $files = $reader->scanDirectory($path);
        foreach ($files as $file) {
//            dump($file->getRealPath());
            $tree = $parser->parse($fs->get($file->getRealPath()));
            dump($tree);
            break;
        }

        $output->writeln('CCN :)');
    }

    protected function getOptions()
    {
        return [
        ];
    }

}
