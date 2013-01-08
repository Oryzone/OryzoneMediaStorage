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

//use Symfony\Component\Form\FormBuilderInterface;

use Oryzone\MediaStorage\Provider\Provider,
    Oryzone\MediaStorage\Model\MediaInterface,
    Oryzone\MediaStorage\Context\ContextInterface,
    Oryzone\MediaStorage\Variant\VariantInterface,
    Oryzone\MediaStorage\Exception\InvalidArgumentException;

class YoutubeProvider extends VideoServiceProvider
{
    /**
     * Canonical url scheme
     */
    const CANONICAL_URL = 'http://www.youtube.com/watch?v=%s';

    /**
     * {@inheritDoc}
     */
    const VALIDATION_REGEX_URL = '%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i';

    /**
     * {@inheritDoc}
     */
    const VALIDATION_REGEX_ID = '%^[^"&?/ ]{11}$%i';

    /**
     * {@inheritDoc}
     */
    public function getName()
    {
        return 'youtube';
    }

    /**
     * {@inheritDoc}
     */
    protected function getDefaultOptions()
    {
        return array(
            'metadata'  => array(
                'title' => 'title',
                'content' => 'description',
                'tags' => 'tags'
            )
        );
    }

    /**
     * {@inheritDoc}
     */
    public function prepare(MediaInterface $media, ContextInterface $context)
    {
        $id = $this->getIdFromContent($media->getContent());

        if($id !== NULL)
        {
            $this->service->load($id);

            $previewImageUrl = $this->service->getMetaValue('thumbnail');
            $previewImageFile = sprintf('%syoutube_preview_%s.jpg', $this->tempDir, $id);
            if(!file_exists($previewImageFile))
                $this->downloadFile($previewImageUrl, $previewImageFile, $media);
            $this->addTempFile($previewImageFile);
            $media->setContent($previewImageFile);

            $media->setMetaValue('id', $id);

            if(isset($this->options['metadata']))
            {
                foreach((array)$this->options['metadata'] as $metaName => $mediaMetaName)
                {
                    $value = $this->service->getMetaValue($metaName);
                    if($value !== NULL)
                        $media->setMetaValue($mediaMetaName, $value);
                }
            }
        }
    }

    /**
     * {@inheritDoc}
     */
    public function render(MediaInterface $media, VariantInterface $variant, $url = NULL, $options = array())
    {
        $defaultOptions = array(
            'mode' => 'video',
            'attributes' => array()
        );

        $options = array_merge($defaultOptions, $options);

        if($options['mode'] != 'video' && $options['mode'] != 'image')
            throw new InvalidArgumentException(sprintf('Invalid mode "%s" to render a Youtube Video. Allowed values: "image", "video"', $options['mode']) );

        switch($options['mode'])
        {
            case 'video':
                $options['attributes'] = array_merge(
                    array(
                        'width' => $variant->getMetaValue('width', 420),
                        'height'=> $variant->getMetaValue('height', 315),
                        'frameborder' => 0,
                        'allowfullscreen' => ''
                    ), $options['attributes']);
                break;

            case 'image':
                $options['attributes'] = array_merge(
                    array(
                        'title' => $media->getName(),
                        'width' => $variant->getMetaValue('width', 420),
                        'height'=> $variant->getMetaValue('height', 315),
                    ), $options['attributes']
                );
                break;
        }

        $htmlAttributes = '';
        foreach($options['attributes'] as $key => $value)
            if($value !== NULL)
                $htmlAttributes .= $key . ($value !== '' ?('="' . $value. '"'):'') . ' ';

        if($options['mode'] == 'video')
            $code = sprintf('<iframe src="http://www.youtube.com/embed/%s" %s></iframe>', $media->getMetaValue('id'), $htmlAttributes);
        else
            $code = sprintf('<img src="%s" %s/>', $url, $htmlAttributes);

        return $code;
    }
}