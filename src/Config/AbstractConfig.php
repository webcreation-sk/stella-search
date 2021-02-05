<?php


namespace Webcreation\StellaSearch\Config;


abstract class AbstractConfig
{
    /**
     * @var array
     */
    protected $config;

    /**
     * AbstractConfig constructor.
     * @param array $config
     */
    public function __construct(array $config = array())
    {
        $config += $this->getDefaultConfig();

        $this->config = $config;
    }

    /**
     * @return mixed
     */
    public function getApiKey()
    {
        return $this->config['apiKey'];
    }

    /**
     * @param $apiKey
     * @return $this
     */
    public function setApiKey($apiKey): AbstractConfig
    {
        $this->config['apiKey'] = $apiKey;

        return $this;
    }

    /**
     * @return array
     */
    abstract public function getDefaultConfig(): array;
}