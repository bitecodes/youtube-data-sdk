<?php

namespace BiteCodes\YouTubeData\Mapper;

use BiteCodes\YouTubeData\Model\Channel;

trait MapChannel
{
    use Mapper;

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
}