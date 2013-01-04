<?php

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
    public function __construct($message = "", $source, $code = 0, $previous = NULL)
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