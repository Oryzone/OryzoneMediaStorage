<?php

/*
 * This file is part of the Oryzone/MediaStorage package.
 *
 * (c) Luciano Mammino <lmammino@oryzone.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

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

    /**
     * {@inheritDoc}
     */
    public function onBeforeModelPersist(MediaInterface $media, $update = FALSE)
    {
        // does nothing
    }

    /**
     * {@inheritDoc}
     */
    public function onAfterModelPersist(MediaInterface $media, $update = FALSE)
    {
        // does nothing
    }

    /**
     * {@inheritDoc}
     */
    public function onBeforeModelRemove(MediaInterface $media)
    {
        // does nothing
    }

    /**
     * {@inheritDoc}
     */
    public function onAfterModelRemove(MediaInterface $media)
    {
        // does nothing
    }
}
