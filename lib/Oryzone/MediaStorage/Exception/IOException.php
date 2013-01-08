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

class IOException extends MediaStorageException
{

    protected $source;

    /**
     * Constructor
     *
     * @param string $message
     * @param mixed $source
     * @param int $code
     * @param null $previous
     */
    public function __construct($message = "", $source = NULL, $code = 0, $previous = NULL)
    {
        parent::__construct($message, $code, $previous);
        $this->source = $source;
    }

    /**
     * Get the source of the input/output exception
     *
     * @return mixed
     */
    public function getSource()
    {
        return $this->source;
    }

}