<?php


namespace Webcreation\StellaSearch\Search;


use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Webcreation\StellaSearch\Constants\SortDirections;

final class Document
{
    /**
     * @var Client
     */
    protected $guzzleClient;

    /**
     * @var SearchIndex
     */
    protected $index;

    /**
     * Document constructor.
     * @param SearchIndex $index
     * @param Client $guzzleClient
     */
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
     * @param string|null $sortBy
     * @param string|null $sortDirection
     * @param bool $includeToStatistics
     * @return mixed
     */
    public function search(
        string $search = '',
        int $page = 1,
        int $perPage = 20,
        array $filter = [],
        string $sortBy = null,
        string $sortDirection = null,
        bool $includeToStatistics = true
    )
    {

        if (isset($sortDirection) && !in_array(strtolower($sortDirection), SortDirections::DIRECTIONS)) {
            throw new \InvalidArgumentException('Wrong sort direction');
        }

        $request['json'] = [
            'q' => $search,
            'page' => $page,
            'per_page' => $perPage,
            'filter' => $filter,
            'sort_by' => $sortBy,
            'sort_direction' => $sortDirection,
            'include_to_statistics' => $includeToStatistics,
        ];

        $res = $this->guzzleClient->get('/index/' . $this->index->getId() . '/search', $request);
        return json_decode($res->getBody()->getContents(), true);
    }

    /**
     * @param string $search
     * @param array $fields
     * @param int $page
     * @param int $perPage
     * @return mixed
     */
    public function moreLikeThis(
        string $search,
        array $fields,
        int $page = 1,
        int $perPage = 20
    )
    {
        $request['json'] = [
            'q' => $search,
            'fields' => $fields,
            'page' => $page,
            'per_page' => $perPage
        ];

        $res = $this->guzzleClient->get('/index/' . $this->index->getId() . '/more-like-this', $request);
        return json_decode($res->getBody()->getContents(), true);
    }

    /**
     * @param array $id
     * @param array $fields
     * @param int $page
     * @param int $perPage
     * @return mixed
     */
    public function moreLikeThisByDocumentId(
        array $id,
        array $fields,
        int $page = 1,
        int $perPage = 20
    )
    {
        $request['json'] = [
            'id' => $id,
            'fields' => $fields,
            'page' => $page,
            'per_page' => $perPage
        ];

        $res = $this->guzzleClient->get('/index/' . $this->index->getId() . '/more-like-this-id', $request);
        return json_decode($res->getBody()->getContents(), true);
    }

    /**
     * @param string $search
     * @param int $limit
     * @return mixed
     * @throws GuzzleException
     */
    public function autocomplete(string $search, int $limit = 10)
    {
        $request['json'] = [
            'q' => $search,
            'limit' => $limit
        ];

        $res = $this->guzzleClient->get('/index/' . $this->index->getId() . '/autocomplete', $request);
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

        $res = $this->guzzleClient->post('/index/' . $this->index->getId() . '/document', $request);
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