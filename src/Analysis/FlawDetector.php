<?php

namespace Inspector\Analysis;

use PhpParser\Node;
use Inspector\Misc\ParametersInterface;
use Inspector\Analysis\FlawDetection\CheckerInterface;

/**
 * Detects and returns all the flaws in a method/function
 * @author Kabir Baidhya
 */
class FlawDetector implements InspectorInterface
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
     * @return array
     */
    protected function checkers()
    {
        return require BASEPATH . 'config/checkers.config.php';
    }
}
