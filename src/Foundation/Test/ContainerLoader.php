<?php


namespace Inspector\Foundation\Test;

use Inspector\Application\IocBinder;
use Inspector\Application\ServiceContainer;


/**
 * @author Kabir Baidhya
 */
class ContainerLoader
{

    protected static $container;

    /**
     * @return ServiceContainer
     */
    public static function loadContainer($configFile)
    {
        if (!static::$container) {
            $container = new ServiceContainer();
            $iocBinder = new IocBinder($container);
            $iocBinder->preBind();
            $config = require $configFile;
            $iocBinder->postBind($config);
            static::$container = $container;
        }

        return static::$container;
    }
}
