<?php

namespace Analyzer\Analysis;


use Analyzer\Analysis\FlawDetection\EvalDetector;
use Analyzer\Analysis\FlawDetection\LinesOfCodeChecker;
use Analyzer\Misc\ParametersInterface;
use PhpParser\Node;
use Analyzer\Analysis\FlawDetection\DieDetector;
use Analyzer\Analysis\FlawDetection\GotoDetector;
use Analyzer\Analysis\FlawDetection\CheckerInterface;


/**
 * Detects and returns all the flaws in a method/function
 * @author Kabir Baidhya
 *
 */
class FlawDetector implements AnalyzerInterface
{

    /**
     * @var array
     */
    protected $config;

    public function __construct(array $config)
    {
        $this->config = $config;
    }

    /**
     * @param Node[]|null $ast
     * @return array
     */
    public function analyze($ast)
    {
        $walker = new NodeWalker();

        $errors = $walker->walk($ast, function ($node) {

            foreach ($this->checkers() as $class) {

                /** @var CheckerInterface $checker */
                $checker = new $class();

                if ($checker instanceof ParametersInterface) {
                    $checker->setParameters($this->config);
                }
                $checker->check($node);
            }

        });

        return $errors;
    }


    /**
     * @return CheckerInterface[]
     */
    protected function checkers()
    {
        return [
            LinesOfCodeChecker::class,
            GotoDetector::class,
            DieDetector::class,
            EvalDetector::class
        ];
    }
}
