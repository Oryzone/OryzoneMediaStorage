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
//use Oryzone\Bundle\MediaStorageBundle\Form\DataTransformer\VideoServiceDataTransformer;

use Imagine\Image\ImagineInterface;

use Oryzone\MediaStorage\Exception\ProviderPrepareException,
    Oryzone\MediaStorage\Model\MediaInterface,
    Oryzone\MediaStorage\Integration\Video\VideoServiceInterface;

abstract class VideoServiceProvider extends ImageProvider
{
    /**
     * Regex to validate service video urls
     * @const string VALIDATION_REGEX_URL
     */
    const VALIDATION_REGEX_URL = NULL;

    /**
     * Regex to validate service ids
     * @const string VALIDATION_REGEX_ID
     */
    const VALIDATION_REGEX_ID = NULL;

    /**
     * Canonical url scheme that identifies the video
     * @const string CANONICAL_URL
     */
    const CANONICAL_URL = NULL;

    /**
     * The service that handles the API calls to retrieve information
     *
     * @var \Oryzone\MediaStorage\Integration\Video\VideoServiceInterface
     */
    protected $service;

    /**
     * Constructor
     *
     * @param string $tempDir
     * @param \Imagine\Image\ImagineInterface $imagine
     * @param \Oryzone\MediaStorage\Integration\Video\VideoServiceInterface $service
     */
    public function __construct($tempDir, ImagineInterface $imagine, VideoServiceInterface $service)
    {
        parent::__construct($tempDir, $imagine);
        $this->service = $service;
    }

    /**
     * Tries to extract the video id from a string (generally the media content)
     *
     * @param $content
     * @return string|NULL
     */
    protected function getIdFromContent($content)
    {
        $id = NULL;
        if( preg_match(static::VALIDATION_REGEX_URL, $content, $matches) )
            $id = $matches[1];
        else if( preg_match(static::VALIDATION_REGEX_ID, $content, $matches) )
            $id = $matches[0];

        return $id;
    }

    /**
     * {@inheritDoc}
     */
    public function hasChangedContent(MediaInterface $media)
    {
        return ($media->getContent() != NULL && $this->getIdFromContent($media) !== $media->getMetaValue('id'));
    }

    /**
     * {@inheritDoc}
     */
    public function validateContent($content)
    {
        return preg_match(static::VALIDATION_REGEX_URL, $content) ||
            preg_match(static::VALIDATION_REGEX_ID, $content);
    }

    /**
     * Downloads a file from an url to a given destination
     * (Usually used to download preview images)
     *
     * @param $url
     * @param $destination
     * @param MediaInterface $media
     * @throws \Oryzone\MediaStorage\Exception\ProviderPrepareException
     * @return void
     */
    protected function downloadFile($url, $destination, MediaInterface $media = NULL)
    {
        try
        {
            $fp = fopen($destination, 'w');
            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_FILE, $fp);
            curl_exec($ch);
            curl_close($ch);
            fclose($fp);
        }
        catch(\Exception $e)
        {
            throw new ProviderPrepareException(sprintf('Cannot downoad file "%s": $s', $url, $e->getMessage()), $this, $media);
        }
    }

    /*
     * {@inheritDoc}
    public function buildMediaType(FormBuilderInterface $formBuilder, array $options = array())
    {
        $fieldOptions = array();
        if(isset($options['edit']) && $options['edit'] == TRUE)
            $fieldOptions = array('required' => FALSE);

        $formBuilder->add('content', 'text', $fieldOptions)
            ->addViewTransformer(new VideoServiceDataTransformer(static::CANONICAL_URL));
    }
    */
}