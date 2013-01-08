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

use Oryzone\MediaStorage\Model\MediaInterface,
    Oryzone\MediaStorage\Variant\VariantInterface;

interface CdnInterface
{

    /**
     * Sets an array of options
     *
     * @param  array                                                    $configuration
     * @return mixed
     * @throws \Oryzone\MediaStorage\Exception\InvalidArgumentException if the options array is not valid
     */
    public function setConfiguration($configuration);

    /**
     * Retrieves the public url of the media on the current CDN
     *
     * @param  \Oryzone\MediaStorage\Model\MediaInterface     $media
     * @param  \Oryzone\MediaStorage\Variant\VariantInterface $variant
     * @param  array                                          $options
     * @return string
     */
    public function getUrl(MediaInterface $media, VariantInterface $variant, $options = array());

}
