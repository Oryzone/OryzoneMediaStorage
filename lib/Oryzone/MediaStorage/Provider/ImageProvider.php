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
    Oryzone\MediaStorage\Exception\ProviderProcessException,
    Oryzone\MediaStorage\Exception\InvalidArgumentException;

class ImageProvider extends FileProvider
{
    /**
     * @var string $tempDir
     */
    protected $tempDir;

    /**
     * @var \Imagine\Image\ImagineInterface $imagine
     */
    protected $imagine;

    /**
     * supported file types
     *
     * @var array $SUPPORTED_TYPES
     */
    protected static $SUPPORTED_TYPES = array(
        'bmp',
        'gif',
        'jpeg', 'jpg',
        'png'
    );

    /**
     * default options array
     *
     * @var array $DEFAULT_OPTIONS
     */
    protected static $DEFAULT_OPTIONS = array(
        'width'         => NULL,
        'height'        => NULL,
        'resize'        => 'stretch',
        'format'        => 'jpg',
        'quality'       => 100,
        'enlarge'       => TRUE
    );

    /**
     * allowed resize modes
     *
     * @var array $ALLOWED_RESIZE_MODES
     */
    protected static $ALLOWED_RESIZE_MODES = array(
        'stretch', 'proportional', 'crop'
    );

    /**
     * Constructor
     *
     * @param string                          $tempDir
     * @param \Imagine\Image\ImagineInterface $imagine
     */
    public function __construct($tempDir, \Imagine\Image\ImagineInterface $imagine = NULL)
    {
        parent::__construct();
        $this->tempDir = $tempDir;
        $this->imagine = $imagine;
    }

    /**
     * {@inheritDoc}
     */
    public function getName()
    {
        return 'image';
    }

    /**
     * Verifies if the temp directory exists and it tries to generate it otherwise
     *
     * @param  string                                                   $tempDir
     * @throws \Oryzone\MediaStorage\Exception\InvalidArgumentException
     */
    protected function checkTempDir($tempDir)
    {
        if (!is_dir($tempDir)) {
            if(file_exists($tempDir))
                throw new InvalidArgumentException(
                    sprintf('Cannot generate temp folder "%s" for the ImageProvider. A file with the same path already exists', $tempDir));

            if (true !== @mkdir($tempDir, 0777, true)) {
                throw new InvalidArgumentException(
                    sprintf('Unable to create temp folder "%s" for the ImageProvider', $tempDir));
            }
        }
    }

    /**
     * Process options array by validating it and merging with default values
     *
     * @param  array                                                    $options
     * @param  string                                                   $variantName
     * @param  string                                                   $contextName
     * @throws \Oryzone\MediaStorage\Exception\InvalidArgumentException
     *
     * @return array
     */
    protected function processOptions($options, $variantName, $contextName)
    {
        // validates options for unsupported keys
        $allowedKeys = array_keys(self::$DEFAULT_OPTIONS);
        foreach ($options as $key => $value) {
            if(!in_array($key, $allowedKeys))
                throw new InvalidArgumentException(
                    sprintf('Unsupported option "%s" for variant "%s" in context "%s". Allowed values are: %s',
                        $key, $variantName, $contextName, json_encode($allowedKeys)));
        }

        $options = array_merge(self::$DEFAULT_OPTIONS, $options);
        if(!in_array($options['resize'], self::$ALLOWED_RESIZE_MODES))
            throw new InvalidArgumentException(
                sprintf('Unsupported value "%s" for key "resize" for variant "%s" in context "%s". Allowed values are: %s',
                    $options['resize'], $variantName, $contextName, json_encode(self::$ALLOWED_RESIZE_MODES)));

        if(!in_array($options['format'], self::$SUPPORTED_TYPES))
            throw new InvalidArgumentException(
                sprintf('Unsupported value "%s" for key "format" for variant "%s" in context "%s". Allowed values are: %s',
                    $options['format'], $variantName, $contextName, json_encode(self::$SUPPORTED_TYPES)));

        if(!is_int($options['quality']) || $options['quality'] < 1 || $options['quality'] > 100)
            throw new InvalidArgumentException(
                sprintf('Unsupported value "%s" for key "quality" for variant "%s" in context "%s". Allowed values are integer values between 1 and 100',
                    $options['quality'], $variantName, $contextName));

        return $options;
    }

    /**
     * {@inheritDoc}
     */
    public function validateContent($content)
    {
        if(is_string($content))
            $content = new \SplFileInfo($content);

        return ($content instanceof \SplFileInfo && $content->isFile() &&
            in_array(strtolower($content->getExtension()), self::$SUPPORTED_TYPES));
    }

    /**
     * {@inheritDoc}
     */
    public function prepare(MediaInterface $media, ContextInterface $context)
    {
        $this->checkTempDir($this->tempDir);
        parent::prepare($media, $context);
    }

    /**
     * {@inheritDoc}
     */
    public function process(MediaInterface $media, VariantInterface $variant, \SplFileInfo $source = NULL)
    {
        $options = $variant->getOptions();
        $result = $source;
        list($originalWidth, $originalHeight) = getimagesize($source->getPathName());
        $width = $originalWidth;
        $height = $originalHeight;

        if (is_array($options) && !empty($options)) {
            if($this->imagine == NULL)
                throw new ProviderProcessException(sprintf('Cannot process image "%s": Imagine library not installed or misconfigured', $media), $this, $media, $variant);

            $options = $this->processOptions($options, $variant->getName(), $media->getContext());

            $destFile = sprintf('%s%s-temp-%s.%s',
                $this->tempDir, date('Y-m-d-h-i-s'), $source->getBasename('.'.$source->getExtension()), $options['format']);

            /**
             * @var \Imagine\Image\ImageInterface $image
             */
            $image = $this->imagine->open( $source );

            $width = $options['width'];
            $height = $options['height'];

            if(
                $options['enlarge'] === TRUE ||
                ($originalWidth >= $width && $originalHeight >= $height)
            )
            {
                if ($options['resize'] == 'proportional') {
                    //calculate missing dimension
                    if($width === NULL)
                        $width = round( $originalWidth * $height / $originalHeight );
                    elseif($height === NULL)
                        $height = round( $width * $originalHeight / $originalWidth );
                }

                $box = new \Imagine\Image\Box($width, $height);

                if($options['resize'] == 'proportional' || $options['resize'] == 'stretch')
                    $image->resize($box);
                elseif( $options['resize'] == 'crop' )
                    $image = $image->thumbnail($box, \Imagine\Image\ImageInterface::THUMBNAIL_OUTBOUND);
            }

            $image->save($destFile, array('quality' => $options['quality']));

            $this->addTempFile($destFile);
            $result = new \SplFileInfo($destFile);
        }

        //set variant metadata
        $variant->setMetaValue('size', $result->getSize());
        $variant->setMetaValue('width', $width);
        $variant->setMetaValue('height', $height);

        return $result;
    }

    /**
     * {@inheritDoc}
     */
    public function render(MediaInterface $media, VariantInterface $variant, $url = NULL, $options = array())
    {
        $attributes = array(
            'title' => $media->getName(),
            'width' => $variant->getMetaValue('width'),
            'height'=> $variant->getMetaValue('height')
        );

        if(isset($options['attributes']))
            $attributes = array_merge($attributes, $options['attributes']);

        $htmlAttributes = '';
        foreach($attributes as $key => $value)
            if($value !== NULL)
                $htmlAttributes .= $key . ($value !== '' ?('="' . $value. '"'):'') . ' ';

        return sprintf('<img src="%s" %s/>',
            $url, $htmlAttributes);
    }
}
