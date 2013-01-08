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
    Oryzone\MediaStorage\Variant\VariantInterface;

interface NamingStrategyInterface
{

    /**
     * Generates a name for a file to be stored.
     * <b>Note</b>: should not add file extension
     *
     * @param  \Oryzone\MediaStorage\Model\MediaInterface     $media
     * @param  \Oryzone\MediaStorage\Variant\VariantInterface $variant
     * @param  \Gaufrette\Filesystem                          $filesystem
     * @return string
     */
    public function generateName(MediaInterface $media, VariantInterface $variant, Filesystem $filesystem);
}
