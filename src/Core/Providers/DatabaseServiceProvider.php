<?php

namespace Rowles\Core\Providers;

use Pimple\Container;
use Rowles\Core\Database;
use Pimple\ServiceProviderInterface;

/**
 * Class DatabaseServiceProvider
 */
class DatabaseServiceProvider implements ServiceProviderInterface
{
    /**
     * Register database service provider.
     *
     * @param Container $container
     * @return Container
     */
    public function register(Container $container)
    {
        $container['db'] = new Database();

        return $container;
    }
}