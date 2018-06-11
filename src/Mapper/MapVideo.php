<?php

namespace BiteCodes\YouTubeData\Mapper;

use BiteCodes\YouTubeData\Model\Video;

trait MapVideo
{
    use Mapper;

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
}
