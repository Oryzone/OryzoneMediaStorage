<?php

namespace Oryzone\MediaStorage\Exception;

use Oryzone\MediaStorage\Model\MediaInterface,
    Oryzone\MediaStorage\Variant\VariantInterface;

class VariantProcessingException extends MediaStorageException
{
    /**
     * @var \Oryzone\MediaStorage\Model\MediaInterface $media
     */
    protected $media;

    /**
     * @var \Oryzone\MediaStorage\Variant\VariantInterface $variant
     */
    protected $variant;

    /**
     * Constructor
     *
     * @param string                                         $message
     * @param \Oryzone\MediaStorage\Model\MediaInterface     $media
     * @param \Oryzone\MediaStorage\Variant\VariantInterface $variant
     * @param int                                            $code
     * @param \Exception                                     $previous
     */
    public function __construct($message = "", MediaInterface $media, VariantInterface $variant, $code = 0, \Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
        $this->media = $media;
        $this->variant = $variant;
    }

    /**
     * Get media
     *
     * @return \Oryzone\MediaStorage\Model\MediaInterface
     */
    public function getMedia()
    {
        return $this->media;
    }

    /**
     * Get variant
     *
     * @return \Oryzone\MediaStorage\Variant\VariantInterface
     */
    public function getVariant()
    {
        return $this->variant;
    }
}