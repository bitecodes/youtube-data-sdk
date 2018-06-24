<?php

namespace BiteCodes\YouTubeData\Model;

class ChannelBrandingSettings
{
    /**
     * @var string
     */
    protected $profileColor;

    /**
     * @var ChannelImage[]
     */
    protected $image;

    /**
     * @return string
     */
    public function getProfileColor()
    {
        return $this->profileColor;
    }

    /**
     * @return ChannelImage[]
     */
    public function getImages()
    {
        return $this->image;
    }

    /**
     * @param ChannelImage[] $image
     *
     * @return ChannelBrandingSettings
     */
    public function setImages(array $image)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * @param $type
     *
     * @return ChannelImage|null
     */
    public function getImageByType($type)
    {
        foreach ($this->image as $image) {
            if ($image->getType() === $type) {
                return $image;
            }
        }
    }
}
