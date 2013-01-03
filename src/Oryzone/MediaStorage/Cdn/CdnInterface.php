<?php

namespace Oryzone\MediaStorage\Cdn;

use Oryzone\MediaStorage\Model\Media,
    Oryzone\MediaStorage\Variant\VariantInterface;

interface CdnInterface
{

    /**
     * Sets an array of options
     *
     * @param  array                                                                 $configuration
     * @return mixed
     * @throws \Oryzone\MediaStorage\Exception\InvalidArgumentException if the options array is not valid
     */
    public function setConfiguration($configuration);

    /**
     * Retrieves the public url of the media on the current CDN
     *
     * @param  \Oryzone\MediaStorage\Model\Media              $media
     * @param  \Oryzone\MediaStorage\Variant\VariantInterface $variant
     * @param   array                                                      $options
     * @return string
     */
    public function getUrl(Media $media, VariantInterface $variant, $options = array());

}
