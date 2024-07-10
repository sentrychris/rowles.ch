<?php

namespace App\Providers;

use Klein\Klein;
use App\Versyx\Service\Container;
use App\Versyx\Service\ServiceProviderInterface;

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