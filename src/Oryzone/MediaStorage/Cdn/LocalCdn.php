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

class LocalCdn implements CdnInterface
{
    /**
     * @var string $path
     */
    protected $path;

    /**
     * {@inheritDoc}
     */
    public function setConfiguration($configuration)
    {
        if(!isset($configuration['path']))
            throw new InvalidArgumentException('Missing mandatory "path" option');

        $this->path = $configuration['path'];
    }

    /**
     * {@inheritDoc}
     */
    public function getUrl(MediaInterface $media, VariantInterface $variant, $options = array())
    {
        $url = $this->path . $variant->getFilename();

        if(isset($options['absolute']) && $options['absolute'])
        {
            if(isset($options['domain']))
                $domain = $options['domain'];
            else
                $domain = $_SERVER['HTTP_HOST'];

            if(isset($options['protocol']))
                $protocol = $options['protocol'];
            else
                $protocol = isset($_SERVER['HTTPS']) ? 'https' : 'http';

            $url = sprintf('%s://%s/%s', $protocol, $domain, ltrim($url, '/'));
        }

        return $url;
    }
}