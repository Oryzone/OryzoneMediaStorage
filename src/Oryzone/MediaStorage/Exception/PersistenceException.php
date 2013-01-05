<?php

namespace Oryzone\MediaStorage\Exception;

use Oryzone\MediaStorage\Persistence\Adapter\PersistenceAdapterInterface;

class PersistenceException extends MediaStorageException
{
    /**
     * @var \Oryzone\MediaStorage\Persistence\Adapter\PersistenceAdapterInterface $persistenceAdapter
     */
    protected $persistenceAdapter;

    /**
     * Constructor
     *
     * @param string $message
     * @param \Oryzone\MediaStorage\Persistence\Adapter\PersistenceAdapterInterface $persistenceAdapter
     * @param int $code
     * @param \Exception $previous
     */
    public function __construct($message = "", PersistenceAdapterInterface $persistenceAdapter = NULL, $code = 0, \Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
        $this->persistenceAdapter = $persistenceAdapter;
    }

    /**
     * Get persistence adapter
     *
     * @return \Oryzone\MediaStorage\Persistence\Adapter\PersistenceAdapterInterface
     */
    public function getPersistenceAdapter()
    {
        return $this->persistenceAdapter;
    }

}