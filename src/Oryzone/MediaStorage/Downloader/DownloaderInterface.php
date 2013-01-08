<?php

namespace Oryzone\MediaStorage\Downloader;

/*
 * This file is part of the Oryzone/MediaStorage package.
 *
 * (c) Luciano Mammino <lmammino@oryzone.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

interface DownloaderInterface
{

    /**
     * Downloads a file from an url and saves it to a given destination
     *
     * @param string $url
     * @param string $destination
     * @throws \Oryzone\MediaStorage\Exception\CannotDownloadFromUrlException if cannot download the resource
     * @throws \Oryzone\MediaStorage\Exception\IOException if cannot save to destination
     */
    public function download($url, $destination);

}