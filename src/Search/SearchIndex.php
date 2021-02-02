<?php


namespace Webcreation\StellaSearch\Search;


use GuzzleHttp\Client;
use Webcreation\StellaSearch\Config\SearchConfig;

final class SearchIndex
{

    /** @var string $indexId */
    protected $indexId;
    /**
     * @var Client
     */
    protected $guzzleClient;
    /**
     * @var SearchConfig
     */
    protected $config;

    public function __construct($indexId, Client $guzzleClient, SearchConfig $config)
    {

        $this->indexId = $indexId;
        $this->guzzleClient = $guzzleClient;
        $this->config = $config;
    }

    /**
     * @return Document
     */
    public function document(): Document
    {
        return new Document($this, $this->guzzleClient);
    }

    public function getId()
    {
        return $this->indexId;
    }



}