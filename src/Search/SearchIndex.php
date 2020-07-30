<?php


namespace Webcreation\StellaSearch\Search;


use GuzzleHttp\Client;
use Webcreation\StellaSearch\Config\SearchConfig;

class SearchIndex
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

    public function getId()
    {
        return $this->indexId;
    }

    public function updateDocument(array $data, $documentId)
    {
        $data['id'] = $documentId;
        $request['json']['data'] = $data;

        return $this->guzzleClient->post('/es/index/' . $this->getId() . '/document',
            $request
        );
    }

    public function search($query, $filters = [], $page = 1, $perPage = 50)
    {

    }

}