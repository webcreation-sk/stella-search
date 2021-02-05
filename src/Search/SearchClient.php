<?php


namespace Webcreation\StellaSearch\Search;


use GuzzleHttp\Client;
use Webcreation\StellaSearch\Config\SearchConfig;

class SearchClient
{

    /**
     * @var SearchConfig
     */
    protected $config;

    /** @var Client $guzzleClient */
    protected $guzzleClient;

    /** @var SearchClient $client */
    protected static $client;

    /**
     * SearchClient constructor.
     * @param Client $guzzleClient
     * @param SearchConfig $config
     */
    public function __construct(Client $guzzleClient, SearchConfig $config)
    {
        $this->guzzleClient = $guzzleClient;
        $this->config = $config;
    }

    /**
     * @return SearchClient
     */
    protected static function get()
    {
        if (!static::$client) {
            static::$client = static::create();
        }

        return static::$client;
    }

    /**
     * @param null $apiKey
     * @return static
     */
    public static function create($apiKey = null)
    {
        return static::createWithConfig(SearchConfig::create($apiKey));
    }

    public static function createWithConfig(SearchConfig $config)
    {
        $config = clone $config;

        $guzzleClient = new Client([
            'base_uri' => SearchConfig::BASE_URI,
            'headers' => [
                'Accept' => 'application/json',
                'Authorization' => 'Bearer ' . $config->getApiKey(),
                'Content-Type' => 'application/json',
            ],
        ]);

        return new static($guzzleClient, $config);
    }

    /**
     * @param $indexId
     * @return SearchIndex
     */
    public function index($indexId): SearchIndex
    {
        return new SearchIndex($indexId, $this->guzzleClient, $this->config);
    }


}