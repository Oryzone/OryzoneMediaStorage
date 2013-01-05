<?php

namespace Oryzone\MediaStorage\Event\Adapter;

use Oryzone\MediaStorage\Model\MediaInterface;

interface EventDispatcherAdapterInterface
{
    /**
     * Called before a media file starts being processed
     *
     * @param \Oryzone\MediaStorage\Model\MediaInterface $media
     * @return void
     */
    public function onBeforeProcess(MediaInterface $media);

    /**
     * Called after a media file ended processing
     *
     * @param \Oryzone\MediaStorage\Model\MediaInterface $media
     * @return void
     */
    public function onAfterProcess(MediaInterface $media);

    /**
     * Called before a media is stored
     *
     * @param \Oryzone\MediaStorage\Model\MediaInterface $media
     * @return mixed
     */
    public function onBeforeStore(MediaInterface $media);

    /**
     * Called after a media is stored
     *
     * @param \Oryzone\MediaStorage\Model\MediaInterface $media
     * @return mixed
     */
    public function onAfterStore(MediaInterface $media);

    /**
     * Called before a media is updated
     *
     * @param \Oryzone\MediaStorage\Model\MediaInterface $media
     * @return mixed
     */
    public function onBeforeUpdate(MediaInterface $media);

    /**
     * Called after a media is updated
     *
     * @param \Oryzone\MediaStorage\Model\MediaInterface $media
     * @return mixed
     */
    public function onAfterUpdate(MediaInterface $media);

    /**
     * Called before a media is removed
     *
     * @param \Oryzone\MediaStorage\Model\MediaInterface $media
     * @return mixed
     */
    public function onBeforeRemove(MediaInterface $media);

    /**
     * Called after a media is removed
     *
     * @param \Oryzone\MediaStorage\Model\MediaInterface $media
     * @return mixed
     */
    public function onAfterRemove(MediaInterface $media);
}