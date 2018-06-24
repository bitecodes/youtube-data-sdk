<?php

namespace BiteCodes\YouTubeData\Mapper;

use BiteCodes\YouTubeData\Model\Channel;
use BiteCodes\YouTubeData\Model\ChannelImage;

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
            || property_exists($item, 'brandingSettings')
        ) {
            $channel = $mapper->map($item, $channel);
        }

        if (property_exists($item, 'brandingSettings')) {
            $mapper->map($item->brandingSettings->channel, $channel->getBrandingSettings());

            $images = [];
            foreach ($item->brandingSettings->image as $type => $url) {
                $image = new ChannelImage();
                $image
                    ->setUrl($url)
                    ->setType($type);

                $images[] = $image;
            }

            $channel->getBrandingSettings()->setImages($images);
        }

        return $channel;
    }
}