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
    public function __construct($message = "", MediaInterface $media = NULL, VariantInterface $variant = NULL, $code = 0, \Exception $previous = null)
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
