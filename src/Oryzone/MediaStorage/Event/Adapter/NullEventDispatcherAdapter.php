<?php

namespace Oryzone\MediaStorage\Event\Adapter;

use Oryzone\MediaStorage\Model\MediaInterface;

class NullEventDispatcherAdapter implements EventDispatcherAdapterInterface
{

    /**
     * {@inheritDoc}
     */
    public function onBeforeProcess(MediaInterface $media)
    {
        // does nothing
    }

    /**
     * {@inheritDoc}
     */
    public function onAfterProcess(MediaInterface $media)
    {
        // does nothing
    }

    /**
     * {@inheritDoc}
     */
    public function onBeforeStore(MediaInterface $media)
    {
        // does nothing
    }

    /**
     * {@inheritDoc}
     */
    public function onAfterStore(MediaInterface $media)
    {
        // does nothing
    }

    /**
     * {@inheritDoc}
     */
    public function onBeforeUpdate(MediaInterface $media)
    {
        // does nothing
    }

    /**
     * {@inheritDoc}
     */
    public function onAfterUpdate(MediaInterface $media)
    {
        // does nothing
    }

    /**
     * {@inheritDoc}
     */
    public function onBeforeRemove(MediaInterface $media)
    {
        // does nothing
    }

    /**
     * {@inheritDoc}
     */
    public function onAfterRemove(MediaInterface $media)
    {
        // does nothing
    }
}
