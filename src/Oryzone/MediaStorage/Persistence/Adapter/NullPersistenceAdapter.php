<?php

namespace Oryzone\MediaStorage\Persistence\Adapter;

use Oryzone\MediaStorage\Model\MediaInterface;

class NullPersistenceAdapter implements PersistenceAdapterInterface
{

    /**
     * {@inheritDoc}
     */
    public function save(MediaInterface $media)
    {
        // does nothing
    }

    /**
     * {@inheritDoc}
     */
    public function update(MediaInterface $media)
    {
        // does nothing
    }

    /**
     * {@inheritDoc}
     */
    public function remove(MediaInterface $media)
    {
        // does nothing
    }
}
