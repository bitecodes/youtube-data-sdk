<?php

namespace BiteCodes\YouTubeData\Response;

use BiteCodes\YouTubeData\Mapper\MapVideo;
use BiteCodes\YouTubeData\Model\Video;

class SearchResponse extends AbstractResponse
{
    use MapVideo;

    /**
     * @var Video[]
     */
    protected $videos;

    /**
     * @return Video[]
     */
    public function getVideos()
    {
        if (!$this->videos) {
            $content = $this->getContent();

            $this->videos = $this->mapVideoList($content->items);
        }

        return $this->videos;
    }

    /**
     * @return string|null
     */
    public function getPrevPageToken()
    {
        $content = $this->getContent();

        return property_exists($content, 'prevPageToken') ? $content->prevPageToken : null;
    }

    /**
     * @return string|null
     */
    public function getNextPageToken()
    {
        $content = $this->getContent();

        return property_exists($content, 'nextPageToken') ? $content->nextPageToken : null;
    }

    /**
     * @return int|null
     */
    public function getTotalResults()
    {
        $content = $this->getContent();

        return property_exists($content, 'pageInfo') ? $content->pageInfo->totalResults : null;
    }
}
