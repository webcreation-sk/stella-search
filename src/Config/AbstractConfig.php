<?php


namespace Webcreation\StellaSearch\Config;


abstract class AbstractConfig
{
    protected $config;

    public function __construct(array $config = array())
    {
        $config += $this->getDefaultConfig();

        $this->config = $config;
    }

    public function getApiKey()
    {
        return $this->config['apiKey'];
    }

    public function setApiKey($apiKey)
    {
        $this->config['apiKey'] = $apiKey;

        return $this;
    }

	abstract public function getDefaultConfig();
}