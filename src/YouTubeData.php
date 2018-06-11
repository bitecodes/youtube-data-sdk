<?php

namespace BiteCodes\YouTubeData;

use BiteCodes\YouTubeData\Model\Channel;
use BiteCodes\YouTubeData\Response\ChannelListResponse;
use BiteCodes\YouTubeData\Response\SearchResponse;
use BiteCodes\YouTubeData\Response\VideoListResponse;
use Http\Client\HttpClient;
use Http\Discovery\HttpClientDiscovery;
use Http\Discovery\MessageFactoryDiscovery;
use Http\Message\MessageFactory;
use Psr\Http\Message\ResponseInterface;

class YouTubeData
{
    const BASE_URL = 'https://www.googleapis.com/youtube/v3';

    /**
     * @var HttpClient
     */
    protected $client;

    /**
     * @var MessageFactory
     */
    protected $messageFactory;

    /**
     * @var string
     */
    protected $apiKey;

    /**
     * @var \JsonMapper
     */
    protected $mapper;

    /**
     * @var array
     */
    protected $currentQuery;

    protected function __construct(HttpClient $client = null, MessageFactory $messageFactory = null)
    {
        $this->client = $client ?: HttpClientDiscovery::find();
        $this->messageFactory = $messageFactory ?: MessageFactoryDiscovery::find();
    }

    /**
     * @param string              $apiKey
     * @param HttpClient|null     $client
     * @param MessageFactory|null $messageFactory
     *
     * @return YouTubeData
     */
    public static function create(string $apiKey, HttpClient $client = null, MessageFactory $messageFactory = null)
    {
        $youtube = new self($client, $messageFactory);
        $youtube->setApiKey($apiKey);

        return $youtube;
    }

    /**
     * @param string $apiKey
     *
     * @return YouTubeData
     */
    public function setApiKey(string $apiKey)
    {
        $this->apiKey = $apiKey;

        return $this;
    }

    /**
     * @param HttpClient $client
     *
     * @return YouTubeData
     */
    public function setClient(HttpClient $client)
    {
        $this->client = $client;

        return $this;
    }

    /**
     * @param MessageFactory $messageFactory
     *
     * @return YouTubeData
     */
    public function setMessageFactory(MessageFactory $messageFactory)
    {
        $this->messageFactory = $messageFactory;

        return $this;
    }

    /**
     * @param string $query
     * @param int    $maxResults
     *
     * @param array  $config
     *
     * @return SearchResponse
     * @throws \Http\Client\Exception
     */
    public function search(string $query, $maxResults = 10, array $config = [])
    {
        $url = self::BASE_URL . '/search';

        $this->currentQuery = array_merge([
            'q'          => $query,
            'maxResults' => $maxResults,
            'part'       => 'snippet',
            'key'        => $this->apiKey,
        ], $config);

        $url .= '?' . http_build_query($this->currentQuery);

        $request = $this->messageFactory->createRequest('GET', $url);
        $response = $this->sendRequest($request);

        return new SearchResponse($response);
    }

    /**
     * @param SearchResponse $lastResponse
     *
     * @return SearchResponse
     * @throws \Http\Client\Exception
     */
    public function moreSearchResults(SearchResponse $lastResponse)
    {
        $url = self::BASE_URL . '/search';

        if (null === $nextPageToken = $lastResponse->getNextPageToken()) {
            throw new \Exception('No more results');
        }

        $query = array_merge($this->currentQuery, [
            'pageToken' => $nextPageToken,
        ]);

        $url .= '?' . http_build_query($query);

        $request = $this->messageFactory->createRequest('GET', $url);
        $response = $this->sendRequest($request);

        return new SearchResponse($response);
    }

    /**
     * @param       $id
     *
     * @param array $parts
     *
     * @return VideoListResponse
     * @throws \Http\Client\Exception
     */
    public function getVideoById($id, $parts = ['snippet', 'contentDetails', 'statistics'])
    {
        $url = self::BASE_URL . '/videos';
        $url .= '?' . http_build_query([
                'id'   => $id,
                'part' => join(',', $parts),
                'key'  => $this->apiKey,
            ]);

        $request = $this->messageFactory->createRequest('GET', $url);
        $response = $this->sendRequest($request);

        return new VideoListResponse($response);
    }

    /**
     * @param string $id
     * @param array  $parts
     *
     * @return ChannelListResponse
     * @throws \Http\Client\Exception
     */
    public function getChannelById(string $id, $parts = ['snippet'])
    {
        $url = self::BASE_URL . '/channels';
        $url .= '?' . http_build_query([
                'id'   => $id,
                'part' => join(',', $parts),
                'key'  => $this->apiKey,
            ]);

        $request = $this->messageFactory->createRequest('GET', $url);
        $response = $this->sendRequest($request);

        return new ChannelListResponse($response);
    }

    /**
     * @param $request
     *
     * @return ResponseInterface
     * @throws \Http\Client\Exception
     */
    protected function sendRequest($request): ResponseInterface
    {
        return $this->client->sendRequest($request);
    }
}
