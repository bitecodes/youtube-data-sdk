<?php

namespace BiteCodes\YouTubeData\Model;

class VideoStatistics
{
    /**
     * @var integer
     */
    protected $viewCount = 0;

    /**
     * @var integer
     */
    protected $likeCount = 0;

    /**
     * @var integer
     */
    protected $dislikeCount = 0;

    /**
     * @var integer
     */
    protected $favoriteCount = 0;

    /**
     * @var integer;
     */
    protected $commentCount = 0;

    /**
     * @return int
     */
    public function getViewCount()
    {
        return $this->viewCount;
    }

    /**
     * @param int $viewCount
     *
     * @return VideoStatistics
     */
    public function setViewCount(int $viewCount)
    {
        $this->viewCount = $viewCount;

        return $this;
    }

    /**
     * @return int
     */
    public function getLikeCount()
    {
        return $this->likeCount;
    }

    /**
     * @param int $likeCount
     *
     * @return VideoStatistics
     */
    public function setLikeCount(int $likeCount)
    {
        $this->likeCount = $likeCount;

        return $this;
    }

    /**
     * @return int
     */
    public function getDislikeCount()
    {
        return $this->dislikeCount;
    }

    /**
     * @param int $dislikeCount
     *
     * @return VideoStatistics
     */
    public function setDislikeCount(int $dislikeCount)
    {
        $this->dislikeCount = $dislikeCount;

        return $this;
    }

    /**
     * @return int
     */
    public function getFavoriteCount()
    {
        return $this->favoriteCount;
    }

    /**
     * @param int $favoriteCount
     *
     * @return VideoStatistics
     */
    public function setFavoriteCount(int $favoriteCount)
    {
        $this->favoriteCount = $favoriteCount;

        return $this;
    }

    /**
     * @return int
     */
    public function getCommentCount()
    {
        return $this->commentCount;
    }

    /**
     * @param int $commentCount
     *
     * @return VideoStatistics
     */
    public function setCommentCount(int $commentCount)
    {
        $this->commentCount = $commentCount;

        return $this;
    }
}
