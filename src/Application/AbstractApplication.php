<?php

namespace Inspector\Application;

use Symfony\Component\Console\Input\InputInterface;
use Inspector\Application\Traits\ConfigurableTrait;
use Inspector\Application\Traits\ContainerAwareTrait;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Application as SymfonyApplication;

/**
 *
 */
abstract class AbstractApplication extends SymfonyApplication
{

    use ConfigurableTrait;
    use ContainerAwareTrait;

    /**
     * Returns the list of commands classes that the application exposes
     *
     * @return array
     */
    abstract protected function getCommands();

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int
     * @throws \Exception
     */
    public function run(InputInterface $input = null, OutputInterface $output = null)
    {
        foreach ($this->getCommands() as $commandClass) {
            $command = $this->getContainer()->make($commandClass);
            $this->add($command);
        }

        return parent::run($input, $output);
    }


}
