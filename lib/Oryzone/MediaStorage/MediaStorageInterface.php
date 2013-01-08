<?php

/*
 * This file is part of the Oryzone/MediaStorage package.
 *
 * (c) Luciano Mammino <lmammino@oryzone.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Oryzone\MediaStorage;

use Oryzone\MediaStorage\Model\MediaInterface;

interface MediaStorageInterface
{

    /**
     * Stores a media
     *
     * @param Model\MediaInterface $media
     */
    public function store(MediaInterface $media);

    /**
     * Update media
     *
     * @param Model\MediaInterface $media
     */
    public function update(MediaInterface $media);

    /**
     * Removes (deletes) a media and connected files
     *
     * @param Model\MediaInterface $media
     */
    public function remove(MediaInterface $media);

    /**
     * Get the url of a media file (if any)
     *
     * @param Model\MediaInterface $media
     * @param string|null          $variant
     * @param array                $options
     *
     * @return string
     */
    public function getUrl(MediaInterface $media, $variant = NULL, $options = array());

    /**
     * Renders a given media
     *
     * @param  Model\MediaInterface $media
     * @param  null                 $variant
     * @param  array                $options
     * @return mixed
     */
    public function render(MediaInterface $media, $variant = NULL, $options = array());

}
