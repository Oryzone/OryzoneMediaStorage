<?php

namespace Oryzone\MediaStorage\Exception;

/*
 * This file is part of the Oryzone/MediaStorage package.
 *
 * (c) Luciano Mammino <lmammino@oryzone.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

class CannotDownloadFromUrlException extends MediaStorageException
{
    /**
     * @var string $url
     */
    protected $url;

    /**
     * Constructor
     *
     * @param string $message
     * @param string $url
     * @param int $code
     * @param \Exception $previous
     */
    public function __construct($message = '', $url = '', $code = 0, \Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
        $this->url = $url;
    }

    /**
     * Get the url
     *
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

}