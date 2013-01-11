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

interface ProviderInterface
{
    /**
     * Content type for file based providers
     */
    const CONTENT_TYPE_FILE = 0;

    /**
     * Content type for providers who use integer ids (numerical ids, like vimeo)
     */
    const CONTENT_TYPE_INT = 1;

    /**
     * Content type for providers who use string ids (like youtube)
     */
    const CONTENT_TYPE_STRING = 2;

    /**
     * Gets the name of the provider
     *
     * @return string
     */
    public function getName();

    /**
     * Get the content type of the current provider
     *
     * @return int
     */
    public function getContentType();

    /**
     * Sets an array of options for the provider
     *
     * @param  array $options
     * @return void
     */
    public function setOptions($options);

    /**
     * Detects if the current content is a new one (used in case of update)
     *
     * @param \Oryzone\MediaStorage\Model\MediaInterface $media
     *
     * @return boolean
     */
    public function hasChangedContent(MediaInterface $media);

    /**
     * Checks if the current provider supports a given Media
     *
     * @param mixed $content
     *
     * @return boolean
     */
    public function validateContent($content);

    /**
     * Executed each time a media is about to be saved, before the process method
     * Generally used to set metadata
     *
     * @param \Oryzone\MediaStorage\Model\MediaInterface     $media
     * @param \Oryzone\MediaStorage\Context\ContextInterface $context
     *
     * @return mixed
     */
    public function prepare(MediaInterface $media, ContextInterface $context);

    /**
     * Process the media to create a variant. Should return a <code>File</code> instance referring
     * the resulting file
     *
     * @param \Oryzone\MediaStorage\Model\MediaInterface     $media
     * @param \Oryzone\MediaStorage\Variant\VariantInterface $variant
     * @param \SplFileInfo                                   $source
     *
     * @return \SplFileInfo|null
     */
    public function process(MediaInterface $media, VariantInterface $variant, \SplFileInfo $source = NULL);

    /**
     * Renders a variant to HTML code. Useful for twig (or other template engines) integrations
     *
     * @param \Oryzone\MediaStorage\Model\MediaInterface     $media
     * @param \Oryzone\MediaStorage\Variant\VariantInterface $variant
     * @param string|null                                    $url
     * @param array                                          $options
     *
     * @return string
     */
    public function render(MediaInterface $media, VariantInterface $variant, $url = NULL, $options = array());

    /**
     * Removes any temp file stored by the current provider instance
     */
    public function removeTempFiles();

}
