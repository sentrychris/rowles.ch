<?php

namespace Rowles\Providers;

use Rowles\Container;
use Rowles\Contracts\ServiceProviderInterface;
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
     * @param Container $container
     * @return Container
     */
    public function register(Container $container): Container
    {
        $container[ViewEngineInterface::class] = new TwigEngine();
        return $container;
    }
}