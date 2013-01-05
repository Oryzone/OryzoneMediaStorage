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

use Oryzone\MediaStorage\Exception\InvalidArgumentException,
    Oryzone\MediaStorage\Exception\InvalidConfigurationException;

class CdnFactory implements CdnFactoryInterface
{
    /**
     * Contains the cdn definitions and instances
     *
     * @var array $map
     */
    protected $map;

    /**
     * Constructor
     *
     * @param array $map the available cdn definitions and instances
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
     * @param array $config
     * @return void
     */
    public function addDefinition($name, $initializer, $initializerParameters = array(), $config = array())
    {
        $this->map[$name] = array(
            'initializer' => $initializer,
            'parameters' => $initializerParameters,
            'config' => $config
        );
    }

    /**
     * Adds an instance to the mapping
     *
     * @param $name
     * @param CdnInterface $instance
     * @return void
     */
    public function addInstance($name, CdnInterface $instance)
    {
        $this->map[$name] = $instance;
    }

    /**
     * {@inheritDoc}
     */
    public function get($cdnName)
    {
        if(!isset($this->map[$cdnName]))
            throw new InvalidArgumentException(sprintf('The cdn "%s" has not been defined', $cdnName));

        $definition = $this->map[$cdnName];
        if( (is_array($definition) && (!isset($definition['initializer']) || !isset($definition['config']))) ||
            (is_object($definition) && !$definition instanceof CdnInterface) )
                throw new InvalidConfigurationException(sprintf('The cdn "%s" is not properly defined: it must be a \Oryzone\MediaStorage\Cdn\CdnInterface object or an array containing "initializer" and "config" keys', $cdnName));

        $cdn = NULL;
        if(is_object($definition))
            $cdn = $definition;
        else
        {
            $config = $definition['config'];
            if(!is_array($config))
                throw new InvalidConfigurationException(sprintf('The cdn "%s" is not properly defined: the key "config" must be an array', $cdnName));

            $initializer = $definition['initializer'];

            if(is_string($initializer))
            {
                if(!class_exists($initializer))
                    throw new InvalidConfigurationException(sprintf('The cdn "%s" is not properly defined: the key "initializer" is set to the string "%s" that cannot be resolved to an existent class', $cdnName, $initializer));

                $cdn = new $initializer;
            }
            elseif(is_callable($initializer))
            {
                $initializerParameters = array();
                if(isset($definition['parameters']))
                    $initializerParameters = $definition['parameters'];

                $cdn = call_user_func_array($initializer, $initializerParameters);
                if(!$cdn instanceof CdnInterface)
                    throw new InvalidConfigurationException(sprintf('The cdn "%s" is not properly defined: the initializer does not returned an instance of \Oryzone\MediaBundle\Cdn\CdnInterface', $cdnName));
            }

            $cdn->setConfiguration($config);
        }

        return $cdn;
    }
}