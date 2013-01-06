<?php

/*
 * This file is part of the Oryzone/MediaStorage package.
 *
 * (c) Luciano Mammino <lmammino@oryzone.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Oryzone\MediaStorage\Cdn;

use Pimple;
use Closure;

use Oryzone\MediaStorage\Exception\InvalidArgumentException,
    Oryzone\MediaStorage\Exception\InvalidConfigurationException;

class PimpleCdnFactory implements CdnFactoryInterface
{
    /**
     * @var \Pimple $container
     */
    protected $container;

    /**
     * @var array $config
     */
    protected $config;

    /**
     * Constructor
     *
     * @param \Pimple $container
     */
    public function __construct(Pimple $container)
    {
        $this->container = $container;
        $this->config = array();
    }

    /**
     * @param $name
     * @param \Closure $definition
     * @param array $config
     */
    public function addDefinition($name, \Closure $definition, $config = array())
    {
        $this->container[$name] = $definition;
        $this->config[$name] = $config;
    }

    /**
     * {@inheritDoc}
     */
    public function get($cdnName)
    {
        try
        {
            $cdn = $this->container[$cdnName];
        }
        catch(\InvalidArgumentException $e)
        {
            throw new InvalidArgumentException(sprintf('The cdn "%s" has not been defined', $cdnName), $e->getCode(), $e);
        }

        if( ! $cdn instanceof CdnInterface)
            throw new InvalidConfigurationException(sprintf('The service "%s" in the container is not an instance of "Oryzone\MediaStorage\Cdn\CdnInterface"', $cdnName));

        $cdn->setConfiguration($this->config[$cdnName]);
        return $cdn;
    }
}