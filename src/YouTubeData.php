<?php

namespace BiteCodes\YouTubeData;

use BiteCodes\YouTubeData\Model\Channel;
use BiteCodes\YouTubeData\Model\Video;
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
     * @var ResponseInterface
     */
    protected $lastResponse;

    /**
     * @var object
     */
    protected $lastContents;

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
     * @return Video[]
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
        $contents = $this->getContents($response);

        return $this->mapVideoList($contents->items);
    }

    /**
     * @return Video[]
     * @throws \Http\Client\Exception
     */
    public function moreSearchResults()
    {
        $url = self::BASE_URL . '/search';

        $contents = $this->lastContents;

        if (!isset($contents->nextPageToken)) {
            throw new \Exception('No more results');
        }

        $query = array_merge($this->currentQuery, [
            'pageToken' => $contents->nextPageToken,
        ]);

        $url .= '?' . http_build_query($query);

        $request = $this->messageFactory->createRequest('GET', $url);
        $response = $this->sendRequest($request);
        $contents = $this->getContents($response);

        return $this->mapVideoList($contents->items);
    }

    /**
     * @param       $id
     *
     * @param array $parts
     *
     * @return Video
     * @throws \Http\Client\Exception
     * @throws \JsonMapper_Exception
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

        $contents = $this->getContents($response);

        return $this->mapVideo($contents->items[0]);
    }

    /**
     * @param string $id
     * @param array  $parts
     *
     * @return Channel
     * @throws \Http\Client\Exception
     * @throws \JsonMapper_Exception
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

        $contents = $this->getContents($response);

        return $this->mapChannel($contents->items[0]);
    }

    /**
     * @param $request
     *
     * @return ResponseInterface
     * @throws \Http\Client\Exception
     */
    protected function sendRequest($request): ResponseInterface
    {
        $this->lastContents = null;

        return $this->lastResponse = $this->client->sendRequest($request);
    }

    /**
     * @param $response
     *
     * @return object
     */
    protected function getContents($response)
    {
        if ($response === $this->lastResponse && $this->lastContents === null) {
            $contents = $this->lastContents = json_decode($response->getBody()->getContents());
        } elseif ($response === $this->lastResponse) {
            $contents = $this->lastContents;
        } else {
            $contents = json_decode($response->getBody()->getContents());
        }

        return $contents;
    }

    /**
     * @param object $item
     *
     * @return Video|object
     * @throws \JsonMapper_Exception
     */
    protected function mapVideo($item)
    {
        $mapper = $this->getMapper();

        $video = new Video();
        if (property_exists($item, 'snippet')) {
            $video = $mapper->map($item->snippet, $video);
        }

        if (property_exists($item, 'id') && is_object($item->id)) {
            $video = $mapper->map($item->id, $video);
        } elseif (property_exists($item, 'id') && is_string($item->id)) {
            $id = new \stdClass();
            $id->videoId = $item->id;
            $video = $mapper->map($id, $video);
        }

        if (property_exists($item, 'contentDetails')
            || property_exists($item, 'statistics')
        ) {
            $video = $mapper->map($item, $video);
        }

        return $video;
    }

    /**
     * @param array $items
     *
     * @return Video[]
     */
    protected function mapVideoList(array $items)
    {
        return array_map([$this, 'mapVideo'], $items);
    }

    /**
     * @param $item
     *
     * @return Channel
     * @throws \JsonMapper_Exception
     */
    protected function mapChannel($item)
    {
        $mapper = $this->getMapper();

        $channel = new Channel();
        if (property_exists($item, 'snippet')) {
            $channel = $mapper->map($item->snippet, $channel);
        }

        if (property_exists($item, 'id')
            || property_exists($item, 'contentDetails')
            || property_exists($item, 'statistics')
        ) {
            $channel = $mapper->map($item, $channel);
        }

        return $channel;
    }

    /**
     * @return \JsonMapper
     */
    protected function getMapper(): \JsonMapper
    {
        if (!$this->mapper) {
            $this->mapper = new \JsonMapper();
            $this->mapper->bIgnoreVisibility = true;
        }

        return $this->mapper;
    }
}
