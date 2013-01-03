<?php

namespace Oryzone\MediaStorage\Exception;

use Oryzone\MediaStorage\Provider\ProviderInterface,
    Oryzone\MediaStorage\Model\Media;

class ProviderPrepareException extends MediaStorageException
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
     * Constructor
     *
     * @param string                                           $message
     * @param \Oryzone\MediaStorage\Provider\ProviderInterface $provider
     * @param \Oryzone\MediaStorage\Model\Media                $media
     * @param int                                              $code
     * @param \Exception                                       $previous
     */
    public function __construct($message = "", ProviderInterface $provider = NULL, Media $media = NULL, $code = 0, \Exception $previous = null)
    {
        $this->provider = $provider;
        $this->media = $media;
        parent::__construct($message, $code, $previous);
    }

    /**
     * Get media
     *
     * @return \Oryzone\MediaStorage\Model\Media
     */
    public function getMedia()
    {
        return $this->media;
    }

    /**
     * Get provider
     *
     * @return \Oryzone\MediaStorage\Provider\ProviderInterface
     */
    public function getProvider()
    {
        return $this->provider;
    }

}