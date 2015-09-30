<?php

namespace Inspector\Analysis;

use PhpParser\Node;
use Inspector\Application\Bootstrapper;
use Inspector\Misc\ParametersInterface;
use Inspector\Analysis\Checker\CheckerInterface;

/**
 * Detects and returns all the flaws in a method/function
 *
 * @author Kabir Baidhya
 */
class FlawDetector
{

    /**
     * @var array
     */
    protected $config;

    /**
     * @var Bootstrapper
     */
    protected $bootstrapper;

    /**
     * @param Bootstrapper $bootstrapper
     * @param array $config
     */
    public function __construct(Bootstrapper $bootstrapper, array $config)
    {
        $this->config = $config;
        $this->bootstrapper = $bootstrapper;
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

                $this->bootstrapper->bootstrap($checker);

                $checker->check($node);
            }
        });

        return $errors;
    }

    /**
     * @return array
     */
    protected function checkers()
    {
        return require BASEPATH . 'config/checkers.config.php';
    }
}
