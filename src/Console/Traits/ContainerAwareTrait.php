<?php

namespace Inspector\Console\Traits;

use Inspector\Console\ServiceContainer;

trait ContainerAwareTrait
{
    /**
     * @var ServiceContainer
     */
    protected $container;


    /**
     * @param ServiceContainer $container
     */
    public function setContainer(ServiceContainer $container)
    {
        $this->container = $container;
    }

    /**
     * @return ServiceContainer
     */
    public function getContainer()
    {
        return $this->container;
    }
}
