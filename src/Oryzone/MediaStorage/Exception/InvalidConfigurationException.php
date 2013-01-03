<?php

namespace Oryzone\MediaStorage\Exception;

class InvalidConfigurationException extends MediaStorageException
{
    public function __construct($message = "", $code = 0, \Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
