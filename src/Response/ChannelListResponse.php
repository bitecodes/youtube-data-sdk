<?php

namespace BiteCodes\YouTubeData\Response;

use BiteCodes\YouTubeData\Mapper\MapChannel;
use BiteCodes\YouTubeData\Model\Channel;

class ChannelListResponse extends AbstractResponse
{
    use MapChannel;

    /**
     * @var Channel
     */
    protected $channel;

    /**
     * @return \BiteCodes\YouTubeData\Model\Channel|object
     * @throws \JsonMapper_Exception
     */
    public function getChannel()
    {
        if (!$this->channel) {
            $content = $this->getContent();
            $this->channel = $this->mapChannel($content->items[0]);
        }

        return $this->channel;
    }
}
