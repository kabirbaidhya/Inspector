<?php

namespace Inspector\Console\Traits;

use Inspector\Application;
use Symfony\Component\Yaml\Yaml;

/**
 * Reading config from the file
 */
trait ConfigurableTrait
{
    /**
     * @var array
     */
    protected $config;

    /**
     * Auto detects configuration if any configuration files found
     *
     * @return $this
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public function autodetectConfig()
    {
        $filesystem = $this->getContainer()->make('filesystem');
        $configPath = getcwd() . '/' . Application::APP_DEFAULT_CONFIG;

        $defaultConfig = $filesystem->getRequire('config/default.config.php');

        if ($filesystem->exists($configPath)) {
            $userConfig = Yaml::parse($filesystem->get($configPath));
        } else {
            $userConfig = [];
        }

        $config = $userConfig + $defaultConfig;

        $this->setConfig($config);

        return $this;
    }

    /**
     * @return array
     */
    public function getConfig()
    {
        return $this->config;
    }

    /**
     * @param array $config
     */
    public function setConfig(array $config)
    {
        $this->config = $config;
    }
}
