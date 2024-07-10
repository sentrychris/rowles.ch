<?php

namespace Rowles\Providers;

use Pimple\Container;

use Pimple\ServiceProviderInterface;
use Rowles\Contracts\ViewEngineInterface;
use Rowles\TwigEngine;

/**
 * Class ViewServiceProvider
 */
class ViewServiceProvider implements ServiceProviderInterface
{
    /**
     * Register view service provider.
     *
     * @param Container $pimple
     * @return Container
     */
    public function register(Container $pimple): Container
    {
        $pimple[ViewEngineInterface::class] = new TwigEngine();
        return $pimple;
    }
}