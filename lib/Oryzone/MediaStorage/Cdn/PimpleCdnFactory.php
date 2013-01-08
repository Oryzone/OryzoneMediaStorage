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

use Oryzone\MediaStorage\Exception\InvalidArgumentException,
    Oryzone\MediaStorage\Exception\InvalidConfigurationException;

class PimpleCdnFactory implements CdnFactoryInterface
{
    /**
     * @var \Pimple $container
     */
    protected $container;

    /**
     * @var string $namespace
     */
    protected $namespace;

    /**
     * @var array $config
     */
    protected $config;

    /**
     * Constructor
     *
     * @param \Pimple $container
     * @param string  $namespace
     */
    public function __construct(Pimple $container, $namespace = 'mediastorage_cdn_')
    {
        $this->container = $container;
        $this->namespace = $namespace;
        $this->config = array();
    }

    /**
     * @param $name
     * @param \Closure $definition
     * @param array    $config
     */
    public function addDefinition($name, \Closure $definition, $config = array())
    {
        $name = $this->namespace . $name;
        $this->container[$name] = $definition;
        $this->config[$name] = $config;
    }

    /**
     * {@inheritDoc}
     */
    public function get($cdnName)
    {
        $cdnName = $this->namespace . $cdnName;
        try {
            $cdn = $this->container[$cdnName];
        } catch (\InvalidArgumentException $e) {
            throw new InvalidArgumentException(sprintf('The cdn "%s" has not been defined', $cdnName), $e->getCode(), $e);
        }

        if( ! $cdn instanceof CdnInterface)
            throw new InvalidConfigurationException(sprintf('The service "%s" in the container is not an instance of "Oryzone\MediaStorage\Cdn\CdnInterface"', $cdnName));

        $cdn->setConfiguration($this->config[$cdnName]);

        return $cdn;
    }
}
