<?php

namespace Inspector\Application;

use Inspector\Analysis\Complexity\ComplexityComputerAwareInterface;
use Inspector\Foundation\MessageProviderAwareInterface;

/**
 * @author Kabir Baidhya
 */
class Bootstrapper
{

    /**
     * @var ServiceContainer
     */
    protected $container;

    /**
     * @param ServiceContainer $container
     */
    public function __construct(ServiceContainer $container)
    {
        $this->container = $container;
    }

    /**
     * @param object $object
     * @return object
     */
    public function bootstrap($object)
    {
        if ($object instanceof ComplexityComputerAwareInterface) {
            $object->setComplexityComputer($this->container['complexity-computer']);
        }
        if ($object instanceof MessageProviderAwareInterface) {
            $object->setMessageProvider($this->container['message-provider']);
        }

        return $object;
    }
}
