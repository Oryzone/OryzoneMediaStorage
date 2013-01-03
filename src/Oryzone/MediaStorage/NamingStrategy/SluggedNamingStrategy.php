<?php

namespace Oryzone\MediaStorage\NamingStrategy;

use Gaufrette\Filesystem;

use Oryzone\MediaStorage\Model\Media,
    Oryzone\MediaStorage\Variant\VariantInterface,
    Oryzone\MediaStorage\Exception\InvalidArgumentException;

class SluggedNamingStrategy extends NamingStrategy
{

    /**
     * {@inheritDoc}
     */
    public function generateName(Media $media, VariantInterface $variant, Filesystem $filesystem)
    {
        if( trim($media->getName()) == '' )
            throw new InvalidArgumentException('The given media has no name');

        $name = self::urlize($media->getName());
        $uid = uniqid('-');

        return $name.$uid.'_'.$variant->getName();
    }
}