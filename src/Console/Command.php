<?php

namespace Inspector\Console;

use Inspector\Console\Traits\ContainerAwareTrait;
use Symfony\Component\Console\Command\Command as SymfonyCommand;

/**
 * Base class for Console Command
 */
class Command extends SymfonyCommand
{

    use ContainerAwareTrait;

    protected $name;
    protected $description;

    public function __construct()
    {
        parent::__construct($this->name);
        $this->setDescription($this->description);

        $this->specifyParameters();
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [];
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [];
    }

    /**
     * Specify the arguments and options on the command.
     *
     * @return void
     */
    protected function specifyParameters()
    {
        foreach ($this->getArguments() as $arguments) {
            call_user_func_array([$this, 'addArgument'], $arguments);
        }
        foreach ($this->getOptions() as $options) {
            call_user_func_array([$this, 'addOption'], $options);
        }
    }

}
