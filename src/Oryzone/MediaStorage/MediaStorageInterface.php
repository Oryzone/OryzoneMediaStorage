<?php

namespace Oryzone\MediaStorage;

use Oryzone\MediaStorage\Model\Media;

interface MediaStorageInterface
{

    /**
     * Stores a media
     *
     * @param Model\Media $media
     */
    public function storeMedia(Media $media);

    /**
     * Update media
     *
     * @param Model\Media $media
     */
    public function updateMedia(Media $media);

    /**
     * Removes (deletes) a media and connected files
     *
     * @param Model\Media $media
     */
    public function removeMedia(Media $media);

    /**
     * Get the url of a media file (if any)
     *
     * @param  Model\Media $media
     * @param  string|null      $variant
     * @param  array            $options
     *
     * @return string
     */
    public function getUrl(Media $media, $variant = NULL, $options = array());

    /**
     * Renders a given media
     *
     * @param Model\Media $media
     * @param null $variant
     * @param array $options
     * @return mixed
     */
    public function render(Media $media, $variant = NULL, $options = array());

}
