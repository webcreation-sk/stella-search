<?php


namespace Webcreation\StellaSearch\Search;


use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

final class Document
{
    /**
     * @var Client
     */
    protected $guzzleClient;

    protected $index;

    public function __construct(SearchIndex $index, Client $guzzleClient)
    {
        $this->index = $index;
        $this->guzzleClient = $guzzleClient;
    }

    /**
     * @param string $search
     * @param int $page
     * @param int $perPage
     * @param array $filter
     * @return mixed
     * @throws GuzzleException
     */
    public function search(string $search = '', int $page = 1, int $perPage = 20, array $filter = [])
    {

        $request['json'] = [
            'q' => $search,
            'page' => $page,
            'per_page' => $perPage,
            'filter' => $filter
        ];

        $res = $this->guzzleClient->get('/index/' . $this->index->getId(), $request);

        return json_decode($res->getBody()->getContents(), true);
    }

    /**
     * @param array $data
     * @param $documentId
     * @return mixed
     * @throws GuzzleException
     */
    public function saveDocument(array $data, $documentId)
    {
        $data['id'] = $documentId;
        $request['json']['data'] = $data;

        $res = $this->guzzleClient->post('/index/' . $this->index->getId() . '/document',
            $request
        );
        return json_decode($res->getBody()->getContents(), true);
    }

    /**
     * @param $documentId
     * @return mixed
     * @throws GuzzleException
     */
    public function deleteDocument($documentId)
    {
        $res = $this->guzzleClient->delete('/index/' . $this->index->getId() . '/document/' . $documentId);
        return json_decode($res->getBody()->getContents(), true);
    }

}