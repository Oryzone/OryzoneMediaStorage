<?php

/*
 * This file is part of the Oryzone/MediaStorage package.
 *
 * (c) Luciano Mammino <lmammino@oryzone.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Oryzone\MediaStorage\Exception;

use Oryzone\MediaStorage\Provider\ProviderInterface,
    Oryzone\MediaStorage\Model\MediaInterface,
    Oryzone\MediaStorage\Variant\VariantInterface;

class ProviderProcessException extends MediaStorageException
{
    /**
     * @var \Oryzone\MediaStorage\Provider\ProviderInterface $provider
     */
    protected $provider;

    /**
     * @var \Oryzone\MediaStorage\Model\MediaInterface $media
     */
    protected $media;

    /**
     * @var \Oryzone\MediaStorage\Variant\VariantInterface
     */
    protected $variant;

    /**
     * Constructor
     *
     * @param string                                           $message
     * @param \Oryzone\MediaStorage\Provider\ProviderInterface $provider
     * @param \Oryzone\MediaStorage\Model\MediaInterface       $media
     * @param \Oryzone\MediaStorage\Variant\VariantInterface   $variant
     * @param int                                              $code
     * @param \Exception                                       $previous
     */
    public function __construct($message = "", ProviderInterface $provider = NULL, MediaInterface $media = NULL, VariantInterface $variant = NULL, $code = 0, \Exception $previous = null)
    {
        $this->provider = $provider;
        $this->media = $media;
        $this->variant = $variant;
        parent::__construct($message, $code, $previous);
    }

    /**
     * Get the media
     *
     * @return \Oryzone\MediaStorage\Model\MediaInterface
     */
    public function getMedia()
    {
        return $this->media;
    }

    /**
     * Get the provider
     *
     * @return \Oryzone\MediaStorage\Provider\ProviderInterface
     */
    public function getProvider()
    {
        return $this->provider;
    }

    /**
     * Get the variant
     *
     * @return \Oryzone\MediaStorage\Variant\VariantInterface
     */
    public function getVariant()
    {
        return $this->variant;
    }

}