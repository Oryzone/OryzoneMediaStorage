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
    Oryzone\MediaStorage\Model\MediaInterface;

class ProviderPrepareException extends MediaStorageException
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
     * Constructor
     *
     * @param string                                           $message
     * @param \Oryzone\MediaStorage\Provider\ProviderInterface $provider
     * @param \Oryzone\MediaStorage\Model\MediaInterface       $media
     * @param int                                              $code
     * @param \Exception                                       $previous
     */
    public function __construct($message = "", ProviderInterface $provider = NULL, MediaInterface $media = NULL, $code = 0, \Exception $previous = null)
    {
        $this->provider = $provider;
        $this->media = $media;
        parent::__construct($message, $code, $previous);
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
     * Get provider
     *
     * @return \Oryzone\MediaStorage\Provider\ProviderInterface
     */
    public function getProvider()
    {
        return $this->provider;
    }

}
