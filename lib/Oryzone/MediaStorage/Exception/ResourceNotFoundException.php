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

class ResourceNotFoundException extends MediaStorageException
{

    /**
     * A unique identifier for the resource
     *
     * @var string $id
     */
    protected $id;

    /**
     * @param string $message {@inheritDoc}
     * @param string $id A unique identifier for the resource
     * @param int $code {@inheritDoc}
     * @param \Exception $previous {@inheritDoc}
     */
    public function __construct($message = "", $id = NULL, $code = 0, \Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
        $this->id = $id;
    }

    /**
     * Gets the id
     *
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

}