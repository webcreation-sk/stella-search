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
     * @param string|null $sortBy
     * @param string|null $sortDirection
     * @return mixed
     * @throws GuzzleException
     */
    public function search(
        string $search = '',
        int $page = 1,
        int $perPage = 20,
        array $filter = [],
        string $sortBy = null,
        string $sortDirection = null
    )
    {

        if (isset($sortDirection) && ! in_array(strtolower($sortDirection), SortDirections::DIRECTIONS)) {
            throw new \InvalidArgumentException('Wrong sort direction');
        }

        $request['json'] = [
            'q' => $search,
            'page' => $page,
            'per_page' => $perPage,
            'filter' => $filter,
            'sort_by' => $sortBy,
            'sort_direction' => $sortDirection,
        ];

        $res = $this->guzzleClient->get('/index/' . $this->index->getId(), $request);

        return json_decode($res->getBody()->getContents(), true);
    }

    /**
     * @param string $search
     * @param array $fields
     * @param int $page
     * @param int $perPage
     * @return mixed
     */
    public function moreLikeThat(
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

        $res = $this->guzzleClient->get('/index/' . $this->index->getId() . '/more-like-that', $request);
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