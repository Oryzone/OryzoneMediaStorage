<?php

namespace Oryzone\MediaStorage\Provider;

use Oryzone\MediaStorage\Model\Media,
    Oryzone\MediaStorage\Variant\VariantInterface,
    Oryzone\MediaStorage\Context\Context;

class FileProvider extends Provider
{
    protected $name = 'file';

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
    public function hasChangedContent(Media $media)
    {
        return ($media->getContent() != NULL && $media->getMetaValue('id') !== md5_file($media->getContent()));
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
    public function prepare(Media $media, Context $context)
    {
        $media->setMetaValue('id', md5_file($media->getContent()));
    }

    /**
     * {@inheritDoc}
     */
    public function process(Media $media, VariantInterface $variant, File $source = NULL)
    {
        $variant->setMetaValue('size', $source->getSize());
        return $source;
    }

    /**
     * {@inheritDoc}
     */
    public function render(Media $media, VariantInterface $variant, $url = NULL, $options = array())
    {
        $attributes = array(
            'title' => $media->getName(). ' ('. $variant->getMetaValue('size') . ')'
        );
        if(isset($options['attributes']))
            $attributes = array_merge($attributes, $options['attributes']);

        $htmlAttributes = '';
        if(isset($options['attributes']))
            foreach($attributes as $key => $value)
                if($value !== NULL)
                    $htmlAttributes .= $key . '="' . $value . '" ';

        return sprintf('<a href="%s" %s>%s</a>',
            $url, $htmlAttributes, $media->getName());
    }
}