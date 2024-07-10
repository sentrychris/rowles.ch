<?php

namespace App\Providers;

use App\Container;
use App\Contracts\ServiceProviderInterface;
use App\Contracts\ViewEngineInterface;
use App\TwigEngine;

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