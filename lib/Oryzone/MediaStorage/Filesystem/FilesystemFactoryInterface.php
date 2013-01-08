<?php

/*
 * This file is part of the Oryzone/MediaStorage package.
 *
 * (c) Luciano Mammino <lmammino@oryzone.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Oryzone\MediaStorage\Filesystem;

interface FilesystemFactoryInterface
{

    /**
     * Retrieves a filesystem by its name.
     *
     * @param string $filesystemName name of a filesystem
     *
     * @throws \Oryzone\MediaStorage\Exception\InvalidArgumentException if the filesystem does not exist
     * @return \Gaufrette\Filesystem
     */
    public function get($filesystemName);

}
