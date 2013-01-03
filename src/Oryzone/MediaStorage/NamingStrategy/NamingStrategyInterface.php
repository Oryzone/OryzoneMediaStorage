<?php

namespace Oryzone\MediaStorage\NamingStrategy;

use Gaufrette\Filesystem;

use Oryzone\MediaStorage\Model\Media,
    Oryzone\MediaStorage\Variant\VariantInterface;

interface NamingStrategyInterface
{

    /**
     * Generates a name for a file to be stored.
     * Note: should not add file extension
     *
     * @param  \Oryzone\MediaStorage\Model\Media              $media
     * @param  \Oryzone\MediaStorage\Variant\VariantInterface $variant
     * @param  \Gaufrette\Filesystem                          $filesystem
     * @return string
     */
    public function generateName(Media $media, VariantInterface $variant, Filesystem $filesystem);
}