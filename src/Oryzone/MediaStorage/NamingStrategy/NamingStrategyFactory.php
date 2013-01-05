<?php

/*
 * This file is part of the Oryzone/MediaStorage package.
 *
 * (c) Luciano Mammino <lmammino@oryzone.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Oryzone\MediaStorage\NamingStrategy;

use Oryzone\MediaStorage\Exception\InvalidConfigurationException,
    Oryzone\MediaStorage\Exception\InvalidArgumentException;

class NamingStrategyFactory implements NamingStrategyFactoryInterface
{
    /**
     * Contains the naming strategies definitions and instances
     *
     * @var array $map
     */
    protected $map;

    /**
     * Constructor
     *
     * @param array $map the available namingStrategy definitions and instances
     */
    public function __constructor($map = array())
    {
        $this->map = $map;
    }

    /**
     * Adds a definition to the map of definitions
     *
     * @param string $name
     * @param string|\Callable $initializer
     * @param array $initializerParameters
     * @return void
     */
    public function addDefinition($name, $initializer, $initializerParameters = array())
    {
        $this->map[$name] = array(
            'initializer' => $initializer,
            'parameters' => $initializerParameters
        );
    }

    /**
     * Adds an instance to the mapping
     *
     * @param $name
     * @param NamingStrategyInterface $instance
     * @return void
     */
    public function addInstance($name, NamingStrategyInterface $instance)
    {
        $this->map[$name] = $instance;
    }

    /**
     * {@inheritDoc}
     */
    public function get($namingStrategyName)
    {
        if(!isset($this->map[$namingStrategyName]))
            throw new InvalidArgumentException(sprintf('The namingStrategy "%s" has not been defined', $namingStrategyName));

        $definition = $this->map[$namingStrategyName];
        if( (is_array($definition) && !isset($definition['initializer']))  ||
            (is_object($definition) && !$definition instanceof NamingStrategyInterface) )
            throw new InvalidConfigurationException(sprintf('The namingStrategy "%s" is not properly defined: it must be a \Oryzone\MediaStorage\NamingStrategy\NamingStrategyInterface object or an array containing "initializer" key', $namingStrategyName));

        $namingStrategy = NULL;
        if(is_object($definition))
            $namingStrategy = $definition;
        else
        {
            $initializer = $definition['initializer'];

            if(is_string($initializer))
            {
                if(!class_exists($initializer))
                    throw new InvalidConfigurationException(sprintf('The namingStrategy "%s" is not properly defined: the key "initializer" is set to the string "%s" that cannot be resolved to an existent class', $namingStrategyName, $initializer));

                $namingStrategy = new $initializer;
            }
            elseif(is_callable($initializer))
            {
                $initializerParameters = array();
                if(isset($definition['parameters']))
                    $initializerParameters = $definition['parameters'];

                $namingStrategy = call_user_func_array($initializer, $initializerParameters);
                if(!$namingStrategy instanceof NamingStrategyInterface)
                    throw new InvalidConfigurationException(sprintf('The namingStrategy "%s" is not properly defined: the initializer does not returned an instance of \Oryzone\MediaBundle\NamingStrategy\NamingStrategyInterface', $namingStrategyName));
            }
        }

        return $namingStrategy;
    }
}
