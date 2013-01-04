<?php

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
