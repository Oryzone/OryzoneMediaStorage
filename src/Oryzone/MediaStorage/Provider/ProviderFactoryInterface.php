<?php

namespace Oryzone\MediaStorage\Provider;

interface ProviderFactoryInterface
{

    /**
     * Gets a provider and sets options
     *
     * @param string $providerName
     * @param array $providerOptions
     *
     * @throws \Oryzone\MediaStorage\Exception\InvalidArgumentException
     *
     * @return ProviderInterface
     */
    public function get($providerName, $providerOptions = array());

}
