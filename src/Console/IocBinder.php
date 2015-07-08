<?php

namespace Analyzer\Console;

use Analyzer\Misc\Formatter;
use Analyzer\Generator\Mapper;
use Analyzer\Generator\Database;
use Analyzer\Generator\ColumnHelper;
use Illuminate\Filesystem\Filesystem;
use Analyzer\Generator\BootstrapTemplate;
use Symfony\Component\Console\Input\ArgvInput;
use Symfony\Component\Console\Output\ConsoleOutput;
use Doctrine\DBAL\Configuration as DbalConfiguration;
use Doctrine\DBAL\DriverManager as DoctrineDriverManager;

class IocBinder
{

    /**
     * @param ServiceContainer $container
     */
    public function __construct(ServiceContainer $container)
    {
        $this->container = $container;
    }

    /**
     * Initialize bindings when the application is initialized
     */
    public function preBind()
    {
        $this->container->bind('filesystem', function () {
            return new Filesystem();
        });

        $this->container->bind('input', function () {
            return new ArgvInput();
        });

        $this->container->bind('output', function () {
            return new ConsoleOutput();
        });
    }

    /**
     * Initialize bindings after the application is initialized and config is loaded
     *
     * @param array $configuration
     */
    public function postBind(array $configuration)
    {
        $this->container->instance('config', $configuration);

        $this->container->singleton('connection', function ($container) {
            $connectionParams = $container['config']['database'];

            return DoctrineDriverManager::getConnection($connectionParams, new DbalConfiguration());
        });

        $this->container->singleton('db', function ($container) {
            return new Database($container['connection']);
        });

        $this->container->singleton('column-helper', function () {
            return new ColumnHelper();
        });

        $this->container->singleton('mapper', function ($container) {
            return new Mapper($container['column-helper']);
        });

        $this->container->singleton('formatter', function () {
            return new Formatter();
        });

        $this->container->singleton('form-template', function () {
            return new BootstrapTemplate();
        });

        $this->container->singleton('form-generator', function ($container) {
            $generatorClass = $container['config']['generators']['form'];

            $generator = new $generatorClass();
            $generator->setContainer($container);
            $generator->setTemplate($container['form-template']);

            return $generator;
        });
    }

}
