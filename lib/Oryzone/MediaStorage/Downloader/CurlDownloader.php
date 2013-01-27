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

use Oryzone\MediaStorage\Exception\CannotDownloadFromUrlException;

class CurlDownloader implements DownloaderInterface
{

    /**
     * {@inheritDoc}
     */
    public function download($url, $destination)
    {
        if(!function_exists('curl_init'))
            throw new CannotDownloadFromUrlException('Curl extension not installed', $url);

        try {
            $fp = fopen($destination, 'w');
            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_FAILONERROR, TRUE);
            curl_setopt($ch, CURLOPT_FILE, $fp);
            curl_exec($ch);
            if(curl_error($ch))
                throw new \Exception(curl_error($ch), curl_errno($ch));
            curl_close($ch);
            fclose($fp);
        } catch (\Exception $e) {
            throw new CannotDownloadFromUrlException(sprintf('Cannot downoad from url "%s": %s', $url, $e->getMessage()), $url, 0, $e);
        }
    }
}
