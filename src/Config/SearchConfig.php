<?php


namespace Webcreation\StellaSearch\Config;


class SearchConfig extends AbstractConfig
{
    const BASE_URI = 'https://api.stella-search.com/';

    /**
     * @param null $apiKey
     * @return static
     */
    public static function create($apiKey = null): SearchConfig
    {
        $config = array(
            'apiKey' => null !== $apiKey ? $apiKey : getenv('API_KEY'),
        );

        return new static($config);
    }

    /**
     * @return array
     */
    public function getDefaultConfig(): array
    {
        return array(
            'apiKey' => '',
            'batchSize' => 1000,
        );
    }

}