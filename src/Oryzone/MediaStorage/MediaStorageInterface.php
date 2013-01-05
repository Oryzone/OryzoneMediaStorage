<?php

namespace Oryzone\MediaStorage;

use Oryzone\MediaStorage\Model\MediaInterface;

interface MediaStorageInterface
{

    /**
     * Stores a media
     *
     * @param Model\MediaInterface $media
     */
    public function storeMedia(MediaInterface $media);

    /**
     * Update media
     *
     * @param Model\MediaInterface $media
     */
    public function updateMedia(MediaInterface $media);

    /**
     * Removes (deletes) a media and connected files
     *
     * @param Model\MediaInterface $media
     */
    public function removeMedia(MediaInterface $media);

    /**
     * Get the url of a media file (if any)
     *
     * @param  Model\MediaInterface $media
     * @param  string|null      $variant
     * @param  array            $options
     *
     * @return string
     */
    public function getUrl(MediaInterface $media, $variant = NULL, $options = array());

    /**
     * Renders a given media
     *
     * @param Model\MediaInterface $media
     * @param null $variant
     * @param array $options
     * @return mixed
     */
    public function render(MediaInterface $media, $variant = NULL, $options = array());

}
