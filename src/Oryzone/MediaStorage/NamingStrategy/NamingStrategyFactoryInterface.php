<?php

namespace Oryzone\MediaStorage\NamingStrategy;

interface NamingStrategyFactoryInterface
{

    /**
     * Gets a naming strategy identified by the given name
     *
     * @param $namingStrategyName
     * @return \Oryzone\MediaStorage\NamingStrategy\NamingStrategyInterface
     */
    public function get($namingStrategyName);

}
