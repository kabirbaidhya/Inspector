<?php

namespace Inspector;

use Inspector\Application\IocBinder;
use Inspector\Application\ServiceContainer;
use Inspector\Application\Commands\InitCommand;
use Inspector\Application\Commands\InspectCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Inspector\Application\AbstractApplication as ConsoleApplication;

class Application extends ConsoleApplication
{

    const APP_NAME = 'Inspector';

    const APP_VERSION = '0.0.1';

    const APP_DEFAULT_CONFIG = 'inspector.yml';

    /**
     * @var IocBinder
     */
    protected $binder;

    public function __construct()
    {
        parent::__construct(static::APP_NAME, static::APP_VERSION);

        $this->setContainer(new ServiceContainer());

        $this->binder = new IocBinder($this->getContainer());

        $this->binder->preBind();
    }

    /**
     * Returns the list of commands that the application exposes
     *
     * @return array
     */
    protected function getCommands()
    {
        return [
            InitCommand::class,
            InspectCommand::class,
        ];
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int
     */
    public function run(InputInterface $input = null, OutputInterface $output = null)
    {
        $this->binder->postBind($this->getConfig());

        return parent::run($input, $output);
    }
}
