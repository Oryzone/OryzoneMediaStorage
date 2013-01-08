<?php

/*
 * This file is part of the Oryzone/MediaStorage package.
 *
 * (c) Luciano Mammino <lmammino@oryzone.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Oryzone\MediaStorage\Context;

use Oryzone\MediaStorage\Exception\InvalidArgumentException,
    Oryzone\MediaStorage\Context\Context;

class ContextFactory implements ContextFactoryInterface
{
    /**
     * @var array $map
     */
    protected $map;

    /**
     * Mostly used for caching purposes
     *
     * @var array $instances
     */
    protected $instances;

    /**
     * Constructor
     *
     * @param array $map
     */
    public function __construct($map = array())
    {
        $this->map = $map;
        $this->instances = array();
    }

    /**
     * {@inheritDoc}
     */
    public function get($contextName)
    {
        if(isset($this->instances[$contextName]))

            return $this->instances[$contextName];

        if(!array_key_exists($contextName, $this->map))
            throw new InvalidArgumentException(sprintf('The context "%s" has not been defined', $contextName));

        $c = $this->map[$contextName];
        $providerName = key($c['provider']);
        $providerOptions = $c['provider'][$providerName];
        $context = new Context($contextName, $providerName, $providerOptions, $c['filesystem'], $c['cdn'],
            $c['namingStrategy'], $c['variants'], $c['defaultVariant']);

        $this->instances[$contextName] = $context;

        return $context;
    }
}
