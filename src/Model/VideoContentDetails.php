<?php

namespace BiteCodes\YouTubeData\Model;

class VideoContentDetails
{
    /**
     * @var \DateInterval
     */
    protected $duration;

    /**
     * @var string
     */
    protected $dimension;

    /**
     * @var string
     */
    protected $definition;

    /**
     * @var string
     */
    protected $caption;

    /**
     * @var boolean
     */
    protected $licensedContent;

    /**
     * @var string
     */
    protected $projection;

    /**
     * @return \DateInterval
     */
    public function getDuration()
    {
        return $this->duration;
    }

    /**
     * @return string
     */
    public function getDimension()
    {
        return $this->dimension;
    }

    /**
     * @return string
     */
    public function getDefinition()
    {
        return $this->definition;
    }

    /**
     * @return string
     */
    public function getCaption()
    {
        return $this->caption;
    }

    /**
     * @return bool
     */
    public function isLicensedContent()
    {
        return $this->licensedContent;
    }

    /**
     * @return string
     */
    public function getProjection()
    {
        return $this->projection;
    }
}
