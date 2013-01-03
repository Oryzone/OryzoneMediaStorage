<?php

namespace Oryzone\MediaStorage\Cdn;

use Oryzone\MediaStorage\Exception\InvalidArgumentException;

interface CdnFactoryInterface
{

    /**
     * Gets a cdn identified by a given name
     *
     * @param $cdnName
     * @return CdnInterface
     *
     * @throws \Oryzone\MediaStorage\Exception\InvalidArgumentException if a cdn with the given name does not exists
     */
    public function get($cdnName);

}
