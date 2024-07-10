<?php

namespace App\Providers;

use Klein\Klein;
use App\Container;
use App\Contracts\ServiceProviderInterface;

/**
 * Class RouteServiceProvider
 */
class RouteServiceProvider implements ServiceProviderInterface
{
    /**
     * Register route service provider.
     *
     * @param Container $container
     * @return Container
     */
    public function register(Container $container): Container
    {
        $container['router'] = new Klein();

        return $container;
    }
}