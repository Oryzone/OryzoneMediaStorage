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
    Oryzone\MediaStorage\Variant\VariantInterface,
    Oryzone\MediaStorage\Exception\InvalidArgumentException;

class RemoteCdn implements CdnInterface
{
    /**
     * @var string $baseUrl
     */
    protected $baseUrl;

    /**
     * {@inheritDoc}
     */
    public function setConfiguration($configuration)
    {
        if(!isset($configuration['base_url']))
            throw new InvalidArgumentException('Missing mandatory "base_url" option');

        $this->baseUrl = $configuration['base_url'];
    }

    /**
     * {@inheritDoc}
     */
    public function getUrl(MediaInterface $media, VariantInterface $variant, $options = array())
    {
        return $this->baseUrl . $variant->getFilename();
    }
}
