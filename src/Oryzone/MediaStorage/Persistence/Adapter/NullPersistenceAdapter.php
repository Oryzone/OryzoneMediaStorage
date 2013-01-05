<?php

/*
 * This file is part of the Oryzone/MediaStorage package.
 *
 * (c) Luciano Mammino <lmammino@oryzone.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

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
