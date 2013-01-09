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

use Oryzone\MediaStorage\Exception\InvalidArgumentException,
    Oryzone\MediaStorage\Variant\Variant,
    Oryzone\MediaStorage\Variant\VariantInterface,
    Oryzone\MediaStorage\Context\ContextInterface;

abstract class Media implements MediaInterface
{
    /**
     * A descriptive name
     *
     * @var string $name
     */
    protected $name;

    /**
     * The content of the media (a reference to a file or binary data)
     *
     * @var mixed $content
     */
    protected $content;

    /**
     * The name of the context
     *
     * @var string $context
     */
    protected $context;

    /**
     * Structured array of available variants
     *
     * @var array $variants
     */
    protected $variants;

    /**
     * Structured array of metadata
     *
     * @var array $meta
     */
    protected $meta;

    /**
     * Media creation date
     *
     * @var \DateTime $createdAt
     */
    protected $createdAt;

    /**
     * Media last modification date
     *
     * @var \DateTime $modifiedAt
     */
    protected $modifiedAt;

    /**
     * Constructor
     */
    public function __construct($content = NULL, $contextName = NULL)
    {
        $this->content = $content;
        $this->context = $contextName;
        $this->createdAt = $this->modifiedAt = new \DateTime();
        $this->variants = array();
    }

    /**
     * {@inheritDoc}
     */
    public function setContent($content)
    {
        $this->content = $content;
        $this->modifiedAt = new \DateTime();
    }

    /**
     * {@inheritDoc}
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * {@inheritDoc}
     */
    public function setContextName($contextName)
    {
        $this->context = $contextName;
    }

    /**
     * {@inheritDoc}
     */
    public function getContext()
    {
        return $this->context;
    }

    /**
     * {@inheritDoc}
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
    }

    /**
     * {@inheritDoc}
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set metadata array
     *
     * @param array $meta
     */
    public function setMeta($meta)
    {
        $this->meta = $meta;
    }

    /**
     * Get metadata array
     *
     * @return array
     */
    public function getMeta()
    {
        return $this->meta;
    }

    /**
     * {@inheritDoc}
     */
    public function getMetaValue($key, $default = NULL)
    {
        if(is_array($this->meta) && isset($this->meta[$key]))

            return $this->meta[$key];

        return $default;
    }

    /**
     * {@inheritDoc}
     */
    public function setMetaValue($key, $value)
    {
        if(!is_array($this->meta))
            $this->meta = array();

        $this->meta[$key] = $value;
    }

    /**
     * {@inheritDoc}
     */
    public function setModifiedAt($modifiedAt)
    {
        $this->modifiedAt = $modifiedAt;
    }

    /**
     * {@inheritDoc}
     */
    public function getModifiedAt()
    {
        return $this->modifiedAt;
    }

    /**
     * Set name
     *
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * {@inheritDoc}
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * {@inheritDoc}
     */
    public function hasVariant($name)
    {
        return array_key_exists($name, $this->variants);
    }

    /**
     * {@inheritDoc}
     */
    public function addVariant(VariantInterface $variant)
    {
        $this->variants[$variant->getName()] = $variant->toArray();
    }

    /**
     * {@inheritDoc}
     */
    public function removeVariant($variantName)
    {
        if (array_key_exists($variantName, $this->variants)) {
            unset($this->variants[$variantName]);

            return true;
        }

        return false;
    }

    /**
     * Set variants
     *
     * @param array $variants
     */
    public function setVariants($variants)
    {
        $this->variants = $variants;
    }

    /**
     * {@inheritDoc}
     */
    public function getVariants()
    {
        return $this->variants;
    }

    /**
     * {@inheritDoc}
     */
    public function getVariantInstance($variantName)
    {
        if(!array_key_exists($variantName, $this->variants))
            throw new InvalidArgumentException(sprintf('media "%s" has no variant named "%s" ', $this, $variantName));

        return Variant::fromArray($this->variants[$variantName]);
    }

    /**
     * {@inheritDoc}
     */
    public function __toString()
    {
        return sprintf('Media (%s) - %s', get_class($this), $this->name);
    }

}
