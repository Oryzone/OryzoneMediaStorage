<?php

/*
 * This file is part of the Oryzone/MediaStorage package.
 *
 * (c) Luciano Mammino <lmammino@oryzone.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Oryzone\MediaStorage\Event;

use Oryzone\MediaStorage\Model\MediaInterface;

interface EventDispatcherAdapterInterface
{
    /**
     * Called before a media file starts being processed
     *
     * @param  \Oryzone\MediaStorage\Model\MediaInterface $media
     * @return void
     */
    public function onBeforeProcess(MediaInterface $media);

    /**
     * Called after a media file ended processing
     *
     * @param  \Oryzone\MediaStorage\Model\MediaInterface $media
     * @return void
     */
    public function onAfterProcess(MediaInterface $media);

    /**
     * Called before a media is stored
     *
     * @param  \Oryzone\MediaStorage\Model\MediaInterface $media
     * @return void
     */
    public function onBeforeStore(MediaInterface $media);

    /**
     * Called after a media is stored
     *
     * @param  \Oryzone\MediaStorage\Model\MediaInterface $media
     * @return void
     */
    public function onAfterStore(MediaInterface $media);

    /**
     * Called before a media is updated
     *
     * @param  \Oryzone\MediaStorage\Model\MediaInterface $media
     * @return void
     */
    public function onBeforeUpdate(MediaInterface $media);

    /**
     * Called after a media is updated
     *
     * @param  \Oryzone\MediaStorage\Model\MediaInterface $media
     * @return void
     */
    public function onAfterUpdate(MediaInterface $media);

    /**
     * Called before a media is removed
     *
     * @param  \Oryzone\MediaStorage\Model\MediaInterface $media
     * @return void
     */
    public function onBeforeRemove(MediaInterface $media);

    /**
     * Called after a media is removed
     *
     * @param  \Oryzone\MediaStorage\Model\MediaInterface $media
     * @return void
     */
    public function onAfterRemove(MediaInterface $media);

    /**
     * Called before the model is persisted
     *
     * @param  \Oryzone\MediaStorage\Model\MediaInterface $media
     * @param  bool                                       $update
     * @return void
     */
    public function onBeforeModelPersist(MediaInterface $media, $update = FALSE);

    /**
     * Called after the model is persisted
     *
     * @param  \Oryzone\MediaStorage\Model\MediaInterface $media
     * @param  bool                                       $update
     * @return void
     */
    public function onAfterModelPersist(MediaInterface $media, $update = FALSE);

    /**
     * Called before the model is removed
     *
     * @param  \Oryzone\MediaStorage\Model\MediaInterface $media
     * @return void
     */
    public function onBeforeModelRemove(MediaInterface $media);

    /**
     * Called after the model is removed
     *
     * @param  \Oryzone\MediaStorage\Model\MediaInterface $media
     * @return void
     */
    public function onAfterModelRemove(MediaInterface $media);
}
