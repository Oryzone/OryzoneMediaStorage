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

use Oryzone\MediaStorage\Exception\InvalidArgumentException;

/**
 * Factory for gaufrette filesystems (to decouple the library from the symfony bundle for gaufrette)
 * mostly copied from gaufrette bundle filesystem map:
 * https://github.com/KnpLabs/KnpGaufretteBundle/blob/master/FilesystemMap.php
 */
class FilesystemFactory implements FilesystemFactoryInterface, \IteratorAggregate
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
     * {@inheritDoc}
     */
    public function get($filesystemName)
    {
        if (!isset($this->map[$filesystemName])) {
            throw new InvalidArgumentException(sprintf('No filesystem register for name "%s"', $filesystemName));
        }

        return $this->map[$filesystemName];
    }

    /**
     * {@inheritDoc}
     */
    public function getIterator()
    {
        return new \ArrayIterator($this->map);
    }
}
