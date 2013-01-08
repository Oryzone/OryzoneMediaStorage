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

use Gaufrette\Filesystem;

use Oryzone\MediaStorage\Model\MediaInterface,
    Oryzone\MediaStorage\Variant\VariantInterface,
    Oryzone\MediaStorage\Exception\InvalidArgumentException;

class SluggedNamingStrategy extends NamingStrategy
{

    /**
     * {@inheritDoc}
     */
    public function generateName(MediaInterface $media, VariantInterface $variant, Filesystem $filesystem)
    {
        if( trim($media->getName()) == '' )
            throw new InvalidArgumentException('The given media has no name');

        $name = self::urlize($media->getName());
        $uid = uniqid('-');

        return $name.$uid.'_'.$variant->getName();
    }
}
