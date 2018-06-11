<?php

namespace BiteCodes\YouTubeData\Model;

class Thumbnail
{
    const TYPE_DEFAULT = 'default';
    const TYPE_MEDIUM = 'medium';
    const TYPE_HIGH = 'high';
    const TYPE_STANDARD = 'standard';
    const TYPE_MAX_RES = 'maxRes';

    /**
     * @var string
     */
    protected $url;

    /**
     * @var integer
     */
    protected $width;

    /**
     * @var integer
     */
    protected $height;

    /**
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @return int
     */
    public function getWidth()
    {
        return $this->width;
    }

    /**
     * @return int
     */
    public function getHeight()
    {
        return $this->height;
    }
}
