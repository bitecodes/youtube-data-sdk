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
    public function getDuration(): \DateInterval
    {
        return $this->duration;
    }

    /**
     * @return string
     */
    public function getDimension(): string
    {
        return $this->dimension;
    }

    /**
     * @return string
     */
    public function getDefinition(): string
    {
        return $this->definition;
    }

    /**
     * @return string
     */
    public function getCaption(): string
    {
        return $this->caption;
    }

    /**
     * @return bool
     */
    public function isLicensedContent(): bool
    {
        return $this->licensedContent;
    }

    /**
     * @return string
     */
    public function getProjection(): string
    {
        return $this->projection;
    }
}
