<?php

/*
 * This file is part of the Oryzone/MediaStorage package.
 *
 * (c) Luciano Mammino <lmammino@oryzone.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Oryzone\MediaStorage\Model;

use Oryzone\MediaStorage\Variant\VariantInterface,
    Oryzone\MediaStorage\Exception\InvalidArgumentException;

interface MediaInterface
{
    /**
     * Constant to use as key to set the persistence adapter hint
     */
    const HINT_PERSISTENCE_ADAPTER = 'persistenceAdapter';

    /**
     * Constant to use as key to set the event dispatcher adapter hint
     */
    const HINT_EVENT_DISPATCHER_ADAPTER = 'eventDispatcherAdapter';

    /**
     * Constant to use as key to set the naming strategy hint
     */
    const HINT_NAMING_STRATEGY = 'namingStrategy';

    /**
     * Get the unique id of the media
     *
     * @return string
     */
    public function getId();

    /**
     * Set content
     *
     * @param  mixed $content
     * @return void
     */
    public function setContent($content);

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
     * @param  string $contextName
     * @return void
     */
    public function setContextName($contextName);

    /**
     * Set created at
     *
     * @param \DateTime $createdAt
     */
    public function setCreatedAt($createdAt);

    /**
     * Get created at
     *
     * @return \DateTime
     */
    public function getCreatedAt();

    /**
     * Set a metadata value for a given key
     *
     * @param  string $key
     * @param  mixed  $value
     * @return void
     */
    public function setMetaValue($key, $value);

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
     * Set modified at
     *
     * @param \DateTime $modifiedAt
     */
    public function setModifiedAt($modifiedAt);

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

    /**
     * Adds an hint
     * Hints are used to temporally overwrite media storage configuration,
     * allowing, for example, to use a different Naming Strategy instance when persisting a particular media
     *
     * @param string $key
     * @param mixed $value
     * @return void
     */
    public function addHint($key, $value);

    /**
     * Checks if a given hint has been set
     *
     * @param string $key
     * @return boolean
     */
    public function hasHint($key);

    /**
     * Gets the value of a previously set hint
     *
     * @param string $key
     * @return mixed
     */
    public function getHint($key);

    /**
     * Gets the array of all the previously set hints
     *
     * @return array
     */
    public function getHints();

    /**
     * Removes all the previously set hints
     *
     * @return void
     */
    public function clearHints();

    /**
     * Returns a string that describes the media (mostly used for debug and on the descriptive message on exceptions)
     * @return string
     */
    public function __toString();

}
