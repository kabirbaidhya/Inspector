<?php

namespace Inspector\Test;

use PhpParser\Node;
use PhpParser\Parser;
use Inspector\Application\IocBinder;
use Inspector\Application\ServiceContainer;
use Inspector\Foundation\Test\CommonAssertionsTrait;

class TestCase extends \PHPUnit_Framework_TestCase
{

    use CommonAssertionsTrait;

    protected $container;

    protected function setUp()
    {
        $container = new ServiceContainer();
        $iocBinder = new IocBinder($container);
        $iocBinder->preBind();
        $this->setContainer($container);

        $this->_before();
    }

    /**
     * @param ServiceContainer $container
     * @return $this
     */
    protected function setContainer(ServiceContainer $container)
    {
        $this->container = $container;

        return $this;
    }

    /**
     * @return ServiceContainer
     */
    protected function getContainer()
    {
        return $this->container;
    }

    /**
     * @return Parser
     */
    protected function getParser()
    {
        return $this->getContainer()->make('parser');
    }

    /**
     * @param string $code
     * @return null|Node[]
     */
    protected function parseSource($code)
    {
        return $this->getParser()->parse($code);
    }

    protected function tearDown()
    {
        $this->_after();
    }

    protected function _before()
    {

    }

    protected function _after()
    {

    }


}
