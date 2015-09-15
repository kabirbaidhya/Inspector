<?php
namespace Analyzer\Test;

use Analyzer\Console\IocBinder;
use Analyzer\Console\ServiceContainer;

class TestCase extends \PHPUnit_Framework_TestCase
{

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
