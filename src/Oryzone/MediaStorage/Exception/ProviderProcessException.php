<?php

namespace Oryzone\MediaStorage\Exception;

use Oryzone\MediaStorage\Provider\ProviderInterface,
    Oryzone\MediaStorage\Model\Media,
    Oryzone\MediaStorage\Variant\VariantInterface;

class ProviderProcessException extends MediaStorageException
{
    /**
     * @var \Oryzone\MediaStorage\Provider\ProviderInterface $provider
     */
    protected $provider;

    /**
     * @var \Oryzone\MediaStorage\Model\Media $media
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
     * @param \Oryzone\MediaStorage\Model\Media                $media
     * @param \Oryzone\MediaStorage\Variant\VariantInterface   $variant
     * @param int                                              $code
     * @param \Exception                                       $previous
     */
    public function __construct($message = "", ProviderInterface $provider = NULL, Media $media = NULL, VariantInterface $variant = NULL, $code = 0, \Exception $previous = null)
    {
        $this->provider = $provider;
        $this->media = $media;
        $this->variant = $variant;
        parent::__construct($message, $code, $previous);
    }

    /**
     * Get the media
     *
     * @return \Oryzone\MediaStorage\Model\Media
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