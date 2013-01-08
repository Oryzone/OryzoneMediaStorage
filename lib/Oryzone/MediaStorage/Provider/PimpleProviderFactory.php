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

use Pimple;

use Oryzone\MediaStorage\Exception\InvalidArgumentException,
    Oryzone\MediaStorage\Exception\InvalidConfigurationException;

class PimpleProviderFactory implements ProviderFactoryInterface
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
     * Constructor
     *
     * @param \Pimple $container
     * @param string  $namespace
     */
    public function __construct(Pimple $container, $namespace = 'mediastorage_provider_')
    {
        $this->container = $container;
        $this->namespace = $namespace;
    }

    /**
     * Adds a definition
     *
     * @param string   $name
     * @param callable $definition
     */
    public function addDefinition($name, \Closure $definition)
    {
        $name = $this->namespace . $name;
        $this->container[$name] = $definition;
    }

    /**
     * {@inheritDoc}
     */
    public function get($providerName, $providerOptions = array())
    {
        $providerName = $this->namespace . $providerName;
        try {
            $provider = $this->container[$providerName];
        } catch (\InvalidArgumentException $e) {
            throw new InvalidArgumentException(sprintf('The provider "%s" has not been defined', $providerName), $e->getCode(), $e);
        }

        if( ! $provider instanceof ProviderInterface)
            throw new InvalidConfigurationException(sprintf('The service "%s" in the container is not an instance of "Oryzone\MediaStorage\Provider\ProviderInterface"', $providerName));

        $provider->setOptions($providerOptions);

        return $provider;
    }

}
