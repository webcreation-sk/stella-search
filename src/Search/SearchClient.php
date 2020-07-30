<?php


namespace Webcreation\Stella\Search;


use GuzzleHttp\Client;
use Webcreation\Stella\Config\SearchConfig;

final class SearchClient
{

    /**
     * @var SearchConfig
     */
    protected $config;

    /** @var Client $guzzleClient */
    protected $guzzleClient;

    protected static $client;

    public function __construct(Client $guzzleClient, SearchConfig $config)
    {
        $this->guzzleClient = $guzzleClient;
        $this->config = $config;

    }

    public static function get()
    {
        if (!static::$client) {
            static::$client = static::create();
        }

        return static::$client;
    }

    public static function create($appId = null, $apiKey = null)
    {
        return static::createWithConfig(SearchConfig::create($appId, $apiKey));
    }

    public static function createWithConfig(SearchConfig $config)
    {
        $config = clone $config;

        $guzzleClient = new \GuzzleHttp\Client([
            'base_uri' => SearchConfig::BASE_URI,
            'headers' => [
                'Accept' => 'application/json',
                'Authorization' => 'Bearer ' . $config->getApiKey(),
                'Content-Type' => 'application/json',
            ],
        ]);

        return new static($guzzleClient, $config);
    }

    public function getIndex($indexId)
    {
        return new SearchIndex($indexId, $this->guzzleClient, $this->config);
    }


}