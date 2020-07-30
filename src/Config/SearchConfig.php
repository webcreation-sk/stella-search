<?php


namespace Webcreation\Stella\Config;


class SearchConfig extends AbstractConfig
{
    const BASE_URI = 'http://search-api.local/';

    public static function create($appId = null, $apiKey = null)
    {
        $config = array(
            'appId' => null !== $appId ? $appId : getenv('APP_ID'),
            'apiKey' => null !== $apiKey ? $apiKey : getenv('API_KEY'),
        );

        return new static($config);
    }

    public function getDefaultConfig()
    {
        return array(
            'appId' => '',
            'apiKey' => '',
            'hosts' => null,
            'readTimeout' => $this->defaultReadTimeout,
            'writeTimeout' => $this->defaultWriteTimeout,
            'connectTimeout' => $this->defaultConnectTimeout,
            'batchSize' => 1000,
        );
    }

}