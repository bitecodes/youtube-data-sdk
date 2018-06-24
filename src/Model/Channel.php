<?php

namespace BiteCodes\YouTubeData\Model;

class Channel
{
    /**
     * @var string
     */
    protected $id;

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
    protected $customUrl;

    /**
     * @var \DateTimeImmutable
     */
    protected $publishedAt;

    /**
     * @var Thumbnail[]
     */
    protected $thumbnails;

    /**
     * @var ChannelBrandingSettings
     */
    protected $brandingSettings;

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
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
    public function getUrl()
    {
        return 'https://www.youtube.com/channel/' . $this->id;
    }

    /**
     * @return string
     */
    public function getCustomUrl()
    {
        return $this->customUrl;
    }

    /**
     * @return \DateTimeImmutable
     */
    public function getPublishedAt()
    {
        return $this->publishedAt;
    }

    /**
     * @return Thumbnail[]
     */
    public function getThumbnails()
    {
        return $this->thumbnails;
    }

    /**
     * @param $type
     *
     * @return Thumbnail|null
     */
    public function getThumbnail(string $type)
    {
        return $this->thumbnails[$type] ?? null;
    }

    /**
     * @return ChannelBrandingSettings
     */
    public function getBrandingSettings()
    {
        return $this->brandingSettings;
    }

    /**
     * @param ChannelBrandingSettings $brandingSettings
     *
     * @return Channel
     */
    public function setBrandingSettings(ChannelBrandingSettings $brandingSettings)
    {
        $this->brandingSettings = $brandingSettings;

        return $this;
    }
}
