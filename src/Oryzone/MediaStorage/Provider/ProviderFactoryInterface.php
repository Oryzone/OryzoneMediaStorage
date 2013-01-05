<?php

/*
 * This file is part of the Oryzone/MediaStorage package.
 *
 * (c) Luciano Mammino <lmammino@oryzone.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Oryzone\MediaStorage\Provider;

interface ProviderFactoryInterface
{

    /**
     * Gets a provider and sets options
     *
     * @param string $providerName
     * @param array $providerOptions
     *
     * @throws \Oryzone\MediaStorage\Exception\InvalidArgumentException
     *
     * @return ProviderInterface
     */
    public function get($providerName, $providerOptions = array());

}
