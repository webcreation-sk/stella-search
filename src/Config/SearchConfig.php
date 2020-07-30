<?php


namespace Webcreation\StellaSearch\Config;


class SearchConfig extends AbstractConfig
{
    const BASE_URI = 'https://api.stella-search.com/';

    public static function create($apiKey = null)
    {
        $config = array(
            'apiKey' => null !== $apiKey ? $apiKey : getenv('API_KEY'),
        );

        return new static($config);
    }

    public function getDefaultConfig()
    {
        return array(
            'apiKey' => '',
            'batchSize' => 1000,
        );
    }

}