<?php

/*
 * This file is part of the Oryzone/MediaStorage package.
 *
 * (c) Luciano Mammino <lmammino@oryzone.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

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
