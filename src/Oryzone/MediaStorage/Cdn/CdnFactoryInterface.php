<?php

/*
 * This file is part of the Oryzone/MediaStorage package.
 *
 * (c) Luciano Mammino <lmammino@oryzone.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

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
