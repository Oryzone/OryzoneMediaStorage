<?php

namespace Oryzone\MediaStorage\Model;

use Oryzone\MediaStorage\Variant\VariantInterface,
    Oryzone\MediaStorage\Context\ContextInterface,
    Oryzone\MediaStorage\Exception\InvalidArgumentException;

interface MediaInterface
{
    /**
     * Get the unique id of the media
     *
     * @return string
     */
    public function getId();

    /**
     * Get content
     *
     * @return mixed|null
     */
    public function getContent();

    /**
     * Get context
     *
     * @return string
     */
    public function getContext();

    /**
     * Set the context
     *
     * @param \Oryzone\MediaStorage\Context\ContextInterface $context
     * @return void
     */
    public function setContext(ContextInterface $context);

    /**
     * Get created at
     *
     * @return \DateTime
     */
    public function getCreatedAt();

    /**
     * Get a metadata value for a given key
     *
     * @param string     $key
     * @param mixed|null $default will return this value if the given key does not exist
     * in the metadata array
     *
     * @return mixed|null
     */
    public function getMetaValue($key, $default = NULL);

    /**
     * Get modified at
     *
     * @return \DateTime
     */
    public function getModifiedAt();

    /**
     * Get name
     *
     * @return string
     */
    public function getName();

    /**
     * Checks if the current media has a variant with a given name
     *
     * @param  string $name
     * @return bool
     */
    public function hasVariant($name);

    /**
     * Set a variant with a given name
     *
     * @param \Oryzone\MediaStorage\Variant\VariantInterface $variant
     */
    public function addVariant(VariantInterface $variant);

    /**
     * Remove a variant with a given name
     *
     * @param  string $variantName
     * @return bool
     */
    public function removeVariant($variantName);

    /**
     * Get variants
     *
     * @return array
     */
    public function getVariants();

    /**
     * Creates a <code>Variant</code> instance for a given variant
     *
     * @param $variantName
     * @return \Oryzone\MediaStorage\Variant\VariantInterface
     * @throws \Oryzone\MediaStorage\Exception\InvalidArgumentException
     */
    public function getVariantInstance($variantName);

}
