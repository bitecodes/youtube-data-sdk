<?php

namespace BiteCodes\YouTubeData\Response;

use Psr\Http\Message\ResponseInterface;

class AbstractResponse
{
    /**
     * @var ResponseInterface
     */
    protected $response;

    /**
     * @var object
     */
    protected $content;

    public function __construct(ResponseInterface $response)
    {
        $this->response = $response;
    }

    /**
     * @return object
     */
    protected function getContent()
    {
        if (!$this->content) {
            $this->content = json_decode($this->response->getBody()->getContents());
        }

        return $this->content;
    }
}
