<?php

namespace BiteCodes\YouTubeData\Model;

class VideoStatistics
{
    /**
     * @var integer
     */
    protected $viewCount;

    /**
     * @var integer
     */
    protected $likeCount;

    /**
     * @var integer
     */
    protected $dislikeCount;

    /**
     * @var integer
     */
    protected $favoriteCount;

    /**
     * @var integer;
     */
    protected $commentCount;

    /**
     * @return int
     */
    public function getViewCount(): int
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
    public function getLikeCount(): int
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
    public function getDislikeCount(): int
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
    public function getFavoriteCount(): int
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
    public function getCommentCount(): int
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
