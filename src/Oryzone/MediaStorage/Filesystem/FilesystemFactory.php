<?php

namespace Oryzone\MediaStorage\Filesystem;

use Oryzone\MediaStorage\Exception\InvalidArgumentException;

/**
 * Factory for gaufrette filesystems
 * mostly copied from gaufrette bundle filesystem map:
 * https://github.com/KnpLabs/KnpGaufretteBundle/blob/master/FilesystemMap.php
 */
class FilesystemFactory implements \IteratorAggregate
{
    /**
     * Map of filesystems indexed by their name
     *
     * @var array
     */
    protected $map;

    /**
     * Instantiates a new filesystem map
     *
     * @param array $map
     */
    public function __construct(array $map)
    {
        $this->map = $map;
    }

    /**
     * Retrieves a filesystem by its name.
     *
     * @param string $name name of a filesystem
     *
     * @throws \Oryzone\MediaStorage\Exception\InvalidArgumentException if the filesystem does not exist
     * @return \Gaufrette\Filesystem
     */
    public function get($name)
    {
        if (!isset($this->map[$name])) {
            throw new InvalidArgumentException(sprintf('No filesystem register for name "%s"', $name));
        }

        return $this->map[$name];
    }

    public function getIterator()
    {
        return new \ArrayIterator($this->map);
    }
}
