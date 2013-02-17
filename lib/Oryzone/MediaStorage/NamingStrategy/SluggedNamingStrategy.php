<?php

/*
 * This file is part of the Oryzone/MediaStorage package.
 *
 * (c) Luciano Mammino <lmammino@oryzone.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Oryzone\MediaStorage\NamingStrategy;

use Gaufrette\Filesystem;

use Oryzone\MediaStorage\Model\MediaInterface,
    Oryzone\MediaStorage\Variant\VariantInterface,
    Oryzone\MediaStorage\Exception\InvalidArgumentException;

class SluggedNamingStrategy extends NamingStrategy
{
    protected $maxLength;

    /**
     * Constructor
     *
     * @param int $maxLength truncates the generated name to this length. Using <code>null</code> values will
     * disable this feature. Default: 128
     */
    public function __construct($maxLength = 128)
    {
        $this->maxLength = $maxLength;
    }

    /**
     * {@inheritDoc}
     */
    public function generateName(MediaInterface $media, VariantInterface $variant, Filesystem $filesystem)
    {
        $name = trim($media->getName());
        if( $name == '' )
            throw new InvalidArgumentException('The given media has no name');

        $suffix = uniqid('-').'_'.$variant->getName();

        if( $this->maxLength && function_exists('mb_strlen') )
        {
            $nameMaxLength = $this->maxLength - mb_strlen($suffix);

            if(mb_strlen($name.$suffix) > $this->maxLength)
                $name = mb_substr($name, 0, $nameMaxLength);
        }

        $name = self::urlize($name);

        return $name.$suffix;
    }
}