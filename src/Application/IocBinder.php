<?php

namespace Inspector\Application;

use PhpParser\Lexer;
use PhpParser\Parser;
use Inspector\Analysis\Analyzer;
use Inspector\Analysis\FlawDetector;
use Inspector\Filesystem\CodeScanner;
use Illuminate\Filesystem\Filesystem;
use Symfony\Component\Console\Input\ArgvInput;
use Inspector\Application\Commands\AnalyzeCommand;
use Inspector\Application\Service\AnalyzerService;
use Symfony\Component\Console\Output\ConsoleOutput;

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

        $this->container->bind('code-scanner', function ($container) {
            return new CodeScanner($container['filesystem']);
        });

        $this->container->bind('lexer', function () {
            return new Lexer();
        });

        $this->container->bind('parser', function ($container) {
            return new Parser($container['lexer']);
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

        $this->container->bind('analyzer', function ($container) {
            return new Analyzer(
                $container['parser'],
                new FlawDetector($container['config'])
            );
        });

        $this->container->bind('analyzer-service', function ($container) {
            return new AnalyzerService(
                $container['analyzer'],
                $container['code-scanner']
            );
        });

        $this->container->bind(AnalyzeCommand::class, function ($container) {
            return new AnalyzeCommand(
                $container['analyzer-service']
            );
        });
    }

}