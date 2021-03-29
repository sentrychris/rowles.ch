<?php

namespace Rowles\Providers;

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
     * @param Container $pimple
     * @return Container
     */
    public function register(Container $pimple): Container
    {
        $pimple['router'] = new Klein();

        return $pimple;
    }
}