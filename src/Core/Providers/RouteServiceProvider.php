<?php

namespace Rowles\Core\Providers;

use Klein\Klein;
use Pimple\Container;
use Pimple\ServiceProviderInterface;

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
    public function register(Container $container)
    {
        $container['router'] = new Klein();

        return $container;
    }
}