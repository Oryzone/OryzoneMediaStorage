<?php

namespace Oryzone\MediaStorage\Provider;

use Oryzone\MediaStorage\Exception\InvalidArgumentException,
    Oryzone\MediaStorage\Exception\InvalidConfigurationException;

class ProviderFactory implements ProviderFactoryInterface
{
    /**
     * Contains the provider definitions and instances
     *
     * @var array $map
     */
    protected $map;

    /**
     * Constructor
     *
     * @param array $map the available provider definitions and instances
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
     * @param ProviderInterface $instance
     * @return void
     */
    public function addInstance($name, ProviderInterface $instance)
    {
        $this->map[$name] = $instance;
    }

    /**
     * {@inheritDoc}
     */
    public function get($providerName, $providerOptions = array())
    {
        if(!isset($this->map[$providerName]))
            throw new InvalidArgumentException(sprintf('The provider "%s" has not been defined', $providerName));

        $definition = $this->map[$providerName];
        if( (is_array($definition) && !isset($definition['initializer'])) ||
            (is_object($definition) && !$definition instanceof ProviderInterface) )
            throw new InvalidConfigurationException(sprintf('The provider "%s" is not properly defined: it must be an instance of \Oryzone\MediaStorage\Provider\ProviderInterface or an array containing "initializer" and "config" keys', $providerName));

        $provider = NULL;
        if(is_object($definition))
            $provider = $definition;
        else
        {
            $initializer = $definition['initializer'];

            if(is_string($initializer))
            {
                if(!class_exists($initializer))
                    throw new InvalidConfigurationException(sprintf('The provider "%s" is not properly defined: the key "initializer" is set to the string "%s" that cannot be resolved to an existent class', $providerName, $initializer));

                $provider = new $initializer;
            }
            elseif(is_callable($initializer))
            {
                $initializerParameters = array();
                if(isset($definition['parameters']))
                    $initializerParameters = $definition['parameters'];

                $provider = call_user_func_array($initializer, $initializerParameters);
                if(!$provider instanceof ProviderInterface)
                    throw new InvalidConfigurationException(sprintf('The provider "%s" is not properly defined: the initializer does not returned an instance of \Oryzone\MediaBundle\Provider\ProviderInterface', $providerName));
            }

            $provider->setOptions($providerOptions);
        }

        return $provider;
    }

}