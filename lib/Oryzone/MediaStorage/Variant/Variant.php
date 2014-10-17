<?php

/*
 * This file is part of the Oryzone/MediaStorage package.
 *
 * (c) Luciano Mammino <lmammino@oryzone.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Oryzone\MediaStorage\Variant;

use Oryzone\MediaStorage\Exception\InvalidArgumentException;

class Variant implements VariantInterface
{
    /**
     * Maps variant mode constants to identification strings
     *
     * @var array
     */
    public static $VARIANT_MODE_MAP = array(
        'instant'   => self::MODE_INSTANT,
        'lazy'      => self::MODE_LAZY,
        'queue'     => self::MODE_QUEUE
    );

    /**
     * @var string $name
     */
    protected $name;

    /**
     * @var string $filename
     */
    protected $filename;

    /**
     * @var array $meta
     */
    protected $meta;

    /**
     * @var array $options
     */
    protected $options;

    /**
     * @var int $mode
     */
    protected $mode;

    /**
     * @var int $status
     */
    protected $status;

    /**
     * @var string $error
     */
    protected $error;

    /**
     * Constructor
     *
     * @param string $name The name of the variant
     */
    public function __construct($name = NULL)
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
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * {@inheritDoc}
     */
    public function getFilename()
    {
        return $this->filename;
    }

    /**
     * {@inheritDoc}
     */
    public function setFilename($filename)
    {
        $this->filename = $filename;
    }

    /**
     * {@inheritDoc}
     */
    public function setMeta($meta)
    {
        $this->meta = $meta;
    }

    /**
     * {@inheritDoc}
     */
    public function getMeta()
    {
        return $this->meta;
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
    public function getMetaValue($key, $default = NULL)
    {
        if(isset($this->meta[$key]))

            return $this->meta[$key];

        return $default;
    }

    /**
     * {@inheritDoc}
     */
    public function getOptions()
    {
        return $this->options;
    }

    /**
     * Set the options
     *
     * @param array $options
     */
    public function setOptions($options)
    {
        $this->options = $options;
    }

    /**
     * {@inheritDoc}
     */
    public function getMode()
    {
        return $this->mode;
    }

    /**
     * {@inheritDoc}
     */
    public function setMode($mode)
    {
        if (is_int($mode)) {
            if(!in_array($mode, self::$VARIANT_MODE_MAP))
                throw new InvalidArgumentException(sprintf('Variant mode "%s" is not supported', $mode));
        }

        $this->mode = $mode;
    }

    /**
     * {@inheritDoc}
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set the status
     *
     * @param $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }

    /**
     * {@inheritDoc}
     */
    public function isReady()
    {
        return ($this->status == self::STATUS_READY);
    }

    /**
     * {@inheritDoc}
     */
    public function hasError()
    {
        return ($this->status == self::STATUS_ERROR);
    }

    /**
     * {@inheritDoc}
     */
    public function getError()
    {
        return $this->error;
    }

    /**
     * Set the error
     *
     * @param string $error
     */
    public function setError($error)
    {
        $this->error = $error;
        if($error !== NULL)
            $this->status = self::STATUS_ERROR;
    }

    /**
     * {@inheritDoc}
     */
    public function invalidate()
    {
        $this->status = self::STATUS_INVALIDATED;
    }

    /**
     * {@inheritDoc}
     */
    public function toArray()
    {
        $data = array(
            'name'          => $this->name,
            'filename'      => $this->filename,
            'options'       => $this->options,
            'mode'          => $this->mode,
            'status'        => $this->status
        );

        if(!empty($this->meta))
            $data['meta'] = $this->meta;

        if($this->hasError())
            $data['error'] = $this->error;

        return $data;
    }

    /**
     * {@inheritDoc}
     */
    public static function fromArray($array)
    {
        $variant = new Variant();
        if( isset($array['name']) )
            $variant->setName($array['name']);
        if( isset($array['filename']) )
            $variant->setFilename($array['filename']);
        if( isset($array['options']) )
            $variant->setOptions($array['options']);
        if( isset($array['mode']) )
            $variant->setMode($array['mode']);
        if( isset($array['status']) )
            $variant->setStatus($array['status']);
        if( isset($array['error']) )
            $variant->setError($array['error']);
        if( isset($array['meta']) && is_array($array['meta']) && !empty($array['meta']) )
            $variant->setMeta($array['meta']);

        return $variant;
    }
}
