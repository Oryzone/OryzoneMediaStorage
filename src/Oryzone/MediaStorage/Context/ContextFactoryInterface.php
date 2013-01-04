<?php

namespace Oryzone\MediaStorage\Context;

interface ContextFactoryInterface
{

    /**
     * Gets a context associated to a given unique name
     *
     * @param string $contextName
     *
     * @return ContextInterface
     */
    public function get($contextName);
}
