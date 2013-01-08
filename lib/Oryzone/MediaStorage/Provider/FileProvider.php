<?php

/*
 * This file is part of the Oryzone/MediaStorage package.
 *
 * (c) Luciano Mammino <lmammino@oryzone.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Oryzone\MediaStorage\Provider;

use Oryzone\MediaStorage\Model\MediaInterface,
    Oryzone\MediaStorage\Variant\VariantInterface,
    Oryzone\MediaStorage\Context\ContextInterface;

class FileProvider extends Provider
{
    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * {@inheritDoc}
     */
    public function getName()
    {
        return 'file';
    }

    /**
     * {@inheritDoc}
     */
    public function hasChangedContent(MediaInterface $media)
    {
        $content = $media->getContent();

        return ($content != NULL && $media->getMetaValue('id') !== md5_file($content));
    }

    /**
     * {@inheritDoc}
     */
    public function validateContent($content)
    {
        if(is_string($content))
            $content = new \SplFileInfo($content);

        return ($content instanceof \SplFileInfo && $content->isFile());
    }

    /**
     * {@inheritDoc}
     */
    public function prepare(MediaInterface $media, ContextInterface $context)
    {
        $media->setMetaValue('id', md5_file($media->getContent()));
    }

    /**
     * {@inheritDoc}
     */
    public function process(MediaInterface $media, VariantInterface $variant, \SplFileInfo $source = NULL)
    {
        $variant->setMetaValue('size', $source->getSize());

        return $source;
    }

    /**
     * {@inheritDoc}
     */
    public function render(MediaInterface $media, VariantInterface $variant, $url = NULL, $options = array())
    {
        $attributes = array(
            'title' => $media->getName(). ' ('. $variant->getMetaValue('size') . ')'
        );
        if(isset($options['attributes']))
            $attributes = array_merge($attributes, $options['attributes']);

        $htmlAttributes = '';
            foreach($attributes as $key => $value)
                if($value !== NULL)
                    $htmlAttributes .= $key . '="' . $value . '" ';

        return sprintf('<a href="%s" %s>%s</a>',
            $url, $htmlAttributes, $media->getName());
    }
}
