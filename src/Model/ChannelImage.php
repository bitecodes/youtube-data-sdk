<?php

namespace BiteCodes\YouTubeData\Model;

class ChannelImage
{
    const BANNER_IMAGE_URL = 'bannerImageUrl';
    const BANNER_TABLET_LOW_IMAGE_URL = 'bannerTabletLowImageUrl';
    const BANNER_TABLET_IMAGE_URL = 'bannerTabletImageUrl';
    const BANNER_TABLET_HD_IMAGE_URL = 'bannerTabletHdImageUrl';
    const BANNER_TABLET_EXTRA_HD_IMAGE_URL = 'bannerTabletExtraHdImageUrl';
    const BANNER_MOBILE_IMAGE_URL = 'bannerMobileImageUrl';
    const BANNER_MOBILE_LOW_IMAGE_URL = 'bannerMobileLowImageUrl';
    const BANNER_MOBILE_MEDIUM_HD_IMAGE_URL = 'bannerMobileMediumHdImageUrl';
    const BANNER_MOBILE_HD_IMAGE_URL = 'bannerMobileHdImageUrl';
    const BANNER_MOBILE_EXTRA_HD_IMAGE_URL = 'bannerMobileExtraHdImageUrl';
    const BANNER_TV_IMAGE_URL = 'bannerTvImageUrl';
    const BANNER_TV_LOW_IMAGE_URL = 'bannerTvLowImageUrl';
    const BANNER_TV_MEDIUM_IMAGE_URL = 'bannerTvMediumImageUrl';
    const BANNER_TV_HIGH_IMAGE_URL = 'bannerTvHighImageUrl';

    /**
     * @var string
     */
    protected $url;

    /**
     * @var string
     */
    protected $type;

    /**
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @param string $url
     *
     * @return ChannelImage
     */
    public function setUrl(string $url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param string $type
     *
     * @return ChannelImage
     */
    public function setType(string $type)
    {
        $this->type = $type;

        return $this;
    }
}
