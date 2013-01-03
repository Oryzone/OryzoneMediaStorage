<?php

namespace Oryzone\MediaStorage\Cdn;

use Oryzone\MediaStorage\Exception\InvalidArgumentException,
    Oryzone\MediaStorage\Exception\InvalidConfigurationException;

class CdnFactory implements CdnFactoryInterface
{

    /**
     * Contains the cdn definitions
     *
     * @var array $map
     */
    protected $map;

    /**
     * Constructor
     *
     * @param array $map the available cdn definitions
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
     * {@inheritDoc}
     */
    public function get($cdnName)
    {
        if(!isset($this->map[$cdnName]))
            throw new InvalidArgumentException(sprintf('The cdn "%s" has not been defined', $cdnName));

        $definition = $this->map[$cdnName];
        if(!is_array($definition) || !isset($definition['initializer']) || !isset($definition['config']))
            throw new InvalidConfigurationException(sprintf('The cdn "%s" is not properly defined: it must be an array containing "initializer" and "config" keys', $cdnName));

        $config = $definition['config'];
        if(!is_array($config))
            throw new InvalidConfigurationException(sprintf('The cdn "%s" is not properly defined: the key "config" must be an array', $cdnName));

        $initializer = $definition['initializer'];

        $cdn = NULL;
        if(is_string($initializer))
        {
            if(!class_exists($initializer))
                throw new InvalidConfigurationException(sprintf('The cdn "%s" is not properly defined: the key "initializer" is set to the string "%s" that is not an existent class', $cdnName, $initializer));

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
        return $cdn;
    }
}