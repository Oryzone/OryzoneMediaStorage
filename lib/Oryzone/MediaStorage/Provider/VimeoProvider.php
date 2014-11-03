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
    Oryzone\MediaStorage\Context\ContextInterface,
    Oryzone\MediaStorage\Variant\VariantInterface,
    Oryzone\MediaStorage\Exception\InvalidArgumentException;

class VimeoProvider extends VideoServiceProvider
{
    /**
     * Canonical url scheme
     */
    const CANONICAL_URL = '//vimeo.com/%s';

    /**
     * Embed url scheme
     */
    const EMBED_URL = 'http://player.vimeo.com/video/%s';

    /**
     * {@inheritDoc}
     */
    const VALIDATION_REGEX_URL = '%^https?://(?:www\.)?vimeo\.com/(?:m/)?(\d+)(?:.*)?$%i';

    /**
     * {@inheritDoc}
     */
    const VALIDATION_REGEX_ID = '%^\d+$%';

    /**
     * {@inheritDoc}
     */
    public function getName()
    {
        return 'vimeo';
    }

    /**
     * {@inheritDoc}
     */
    protected function getDefaultOptions()
    {
        return array(
            'metadata'  => array(
                'title' => 'title',
                'description' => 'description',
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

        if ($id !== NULL) {
            $this->service->load($id);

            $previewImageUrl = $this->service->getMetaValue('thumbnail_large');
            $previewImageFile = sprintf('%svimeo_preview_%s.jpg', $this->tempDir, $id);
            $this->addTempFile($previewImageFile);
            if(!file_exists($previewImageFile))
                $this->downloadFile($previewImageUrl, $previewImageFile, $media);
            $media->setContent($previewImageFile);

            $media->setMetaValue('id', $id);
            if (isset($this->options['metadata'])) {
                foreach ((array) $this->options['metadata'] as $metaName => $mediaMetaName) {
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
        $availableModes = array('video', 'image', 'embedUrl', 'url');

        $defaultOptions = array(
            'mode' => 'video',
            'attributes' => array()
        );

        $options = array_merge($defaultOptions, $options);

        if(!in_array($options['mode'], $availableModes))
            throw new InvalidArgumentException(sprintf('Invalid mode "%s" to render a Youtube Video. Allowed values: "%s"', $options['mode'], json_encode($availableModes)) );

        $id = $media->getMetaValue('id');
        $embedUrl = sprintf(self::EMBED_URL, $id);
        if($options['mode'] == 'embedUrl')
            return $embedUrl;

        if($options['mode'] == 'url')
            return sprintf(self::CANONICAL_URL, $id);

        switch ($options['mode']) {
            case 'video':
                $options['attributes'] = array_merge(
                    array(
                        'width' => $variant->getMetaValue('width', 420),
                        'height'=> $variant->getMetaValue('height', 315),
                        'frameborder' => 0,
                        'allowfullscreen' => '',
                        'webkitAllowFullScreen' => '',
                        'mozallowfullscreen' => ''
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
            $code = sprintf('<iframe src="%s" %s></iframe>', $embedUrl, $htmlAttributes);
        else
            $code = sprintf('<img src="%s" %s/>', $url, $htmlAttributes);

        return $code;
    }
}
