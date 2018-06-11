<?php

namespace BiteCodes\YouTubeData\Response;

use BiteCodes\YouTubeData\Mapper\MapVideo;
use BiteCodes\YouTubeData\Model\Video;

class VideoListResponse extends AbstractResponse
{
    use MapVideo;

    /**
     * @var Video
     */
    protected $video;

    /**
     * @return \BiteCodes\YouTubeData\Model\Video|object
     * @throws \JsonMapper_Exception
     */
    public function getVideo()
    {
        if (!$this->video) {
            $content = $this->getContent();
            $this->video = $this->mapVideo($content->items[0]);
        }

        return $this->video;
    }
}