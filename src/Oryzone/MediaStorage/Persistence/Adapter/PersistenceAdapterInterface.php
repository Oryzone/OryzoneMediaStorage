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

interface PersistenceAdapterInterface
{
    /**
     * Persists the media instance
     *
     * @param \Oryzone\MediaStorage\Model\MediaInterface $media
     * @throws \Oryzone\MediaStorage\Exception\PersistenceException if cannot save the media
     * @return void
     */
    public function save(MediaInterface $media);

    /**
     * Updates a previously persistend media instance
     *
     * @param \Oryzone\MediaStorage\Model\MediaInterface $media
     * @throws \Oryzone\MediaStorage\Exception\PersistenceException if cannot update the media
     * @return void
     */
    public function update(MediaInterface $media);

    /**
     * Removes a previously persisted media instance
     *
     * @param \Oryzone\MediaStorage\Model\MediaInterface $media
     * @throws \Oryzone\MediaStorage\Exception\PersistenceException if cannot remove the media
     * @return void
     */
    public function remove(MediaInterface $media);
}
