<?php

namespace BiteCodes\YouTubeData\Model;

class Video
{
    /**
     * @var string
     */
    protected $videoId;

    /**
     * @var string
     */
    protected $title;

    /**
     * @var string
     */
    protected $description;

    /**
     * @var string
     */
    protected $categoryId;

    /**
     * @var string
     */
    protected $liveBroadcastContent;

    /**
     * @var string
     */
    protected $defaultLanguage;

    /**
     * @var string
     */
    protected $defaultAudioLanguage;

    /**
     * @var \DateTimeImmutable
     */
    protected $publishedAt;

    /**
     * @var string
     */
    protected $channelId;

    /**
     * @var string
     */
    protected $channelTitle;

    /**
     * @var array
     */
    protected $tags;

    /**
     * @var Thumbnail[]
     */
    protected $thumbnails;

    /**
     * @var VideoStatistics
     */
    protected $statistics;

    /**
     * @var VideoContentDetails
     */
    protected $contentDetails;

    /**
     * @return string
     */
    public function getVideoId()
    {
        return $this->videoId;
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return 'https://www.youtube.com/watch?v=' . $this->getVideoId();
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @return string
     */
    public function getCategoryId()
    {
        return $this->categoryId;
    }

    /**
     * @return string
     */
    public function getLiveBroadcastContent()
    {
        return $this->liveBroadcastContent;
    }

    /**
     * @return string
     */
    public function getDefaultLanguage()
    {
        return $this->defaultLanguage;
    }

    /**
     * @return string
     */
    public function getDefaultAudioLanguage()
    {
        return $this->defaultAudioLanguage;
    }

    /**
     * @return \DateTimeImmutable
     */
    public function getPublishedAt()
    {
        return $this->publishedAt;
    }

    /**
     * @return string
     */
    public function getChannelId()
    {
        return $this->channelId;
    }

    /**
     * @return string
     */
    public function getChannelTitle()
    {
        return $this->channelTitle;
    }

    /**
     * @return array
     */
    public function getTags(): array
    {
        return $this->tags;
    }

    /**
     * @return Thumbnail[]
     */
    public function getThumbnails()
    {
        return $this->thumbnails;
    }

    /**
     * @return VideoStatistics|null
     */
    public function getStatistics()
    {
        return $this->statistics;
    }

    /**
     * @return VideoContentDetails|null
     */
    public function getDetails()
    {
        return $this->contentDetails;
    }
}
