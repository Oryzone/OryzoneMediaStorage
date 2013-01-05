<?php

/*
 * This file is part of the Oryzone/MediaStorage package.
 *
 * (c) Luciano Mammino <lmammino@oryzone.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Oryzone\MediaStorage\NamingStrategy;

interface NamingStrategyFactoryInterface
{

    /**
     * Gets a naming strategy identified by the given name
     *
     * @param $namingStrategyName
     * @return \Oryzone\MediaStorage\NamingStrategy\NamingStrategyInterface
     */
    public function get($namingStrategyName);

}
