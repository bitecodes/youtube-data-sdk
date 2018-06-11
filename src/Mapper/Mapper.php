<?php

namespace BiteCodes\YouTubeData\Mapper;

trait Mapper
{
    /**
     * @var \JsonMapper
     */
    protected $mapper;

    /**
     * @return \JsonMapper
     */
    protected function getMapper(): \JsonMapper
    {
        if (!$this->mapper) {
            $this->mapper = new \JsonMapper();
            $this->mapper->bIgnoreVisibility = true;
        }

        return $this->mapper;
    }
}
