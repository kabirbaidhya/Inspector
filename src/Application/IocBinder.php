<?php

namespace Inspector\Application;

use PhpParser\Lexer;
use PhpParser\Parser;
use Inspector\Analysis\Analyzer;
use Inspector\Analysis\FlawDetector;
use Inspector\Filesystem\CodeScanner;
use Illuminate\Filesystem\Filesystem;
use Inspector\Foundation\MessageProvider;
use Inspector\Analysis\Complexity\CCNChecker;
use Symfony\Component\Console\Input\ArgvInput;
use Inspector\Analysis\Report\ReportGenerator;
use Inspector\Application\Service\ReportService;
use Inspector\Application\Commands\InspectCommand;
use Inspector\Analysis\Exception\AnalysisException;
use Inspector\Analysis\Feedback\FeedbackInterface;
use Inspector\Application\Service\AnalyzerService;
use Symfony\Component\Console\Output\ConsoleOutput;
use Inspector\Analysis\Complexity\ComplexityComputer;
use Inspector\Analysis\Feedback\ConsolePlainFeedback;

/**
 * TODO: Remove this class and instead introduce laravel style Service Providers
 *
 * @author Kabir Baidhya
 */
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

        $this->container->bind('bootstrapper', function ($container) {
            return new Bootstrapper($container);
        });

        $this->container->bind('complexity-computer', function () {

            // Complexity Computer based upon Cyclomatic Complexity Number
            return new ComplexityComputer(new CCNChecker());
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

        // Setup AnalysisException ComplexityComputing
        AnalysisException::setComplexityComputer($this->container['complexity-computer']);

        $this->container->bind('message-provider', function ($container) {
            return new MessageProvider($container['config']);
        });

        $this->container->bind('flaw-detector', function ($container) {
            return new FlawDetector($container['bootstrapper'], $container['config']);
        });

        $this->container->bind('analyzer', function ($container) {
            return $this->bootstrap(
                new Analyzer(
                    $container['parser'],
                    $container['flaw-detector']
                )
            );
        });

        $this->container->bind(FeedbackInterface::class, function ($container) {
            return new ConsolePlainFeedback($container['config'], $container['output']);
        });

        $this->container->bind('report-generator', function ($container) {
            return new ReportGenerator($container['filesystem']);
        });

        $this->container->bind('report-service', function ($container) {
            return new ReportService($container['report-generator']);
        });

        $this->container->bind('analyzer-service', function ($container) {
            return new AnalyzerService(
                $container['analyzer'],
                $container['code-scanner'],
                $container[FeedbackInterface::class],
                $container['report-service']
            );
        });

        $this->container->bind(InspectCommand::class, function ($container) {
            return new InspectCommand(
                $container['analyzer-service']
            );
        });

    }

    /**
     * @param $object
     * @return mixed
     */
    public function bootstrap($object)
    {
        return $this->container['bootstrapper']->bootstrap($object);
    }

}
