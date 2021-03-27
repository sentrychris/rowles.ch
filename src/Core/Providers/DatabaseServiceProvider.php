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
     * @param Container $pimple
     * @return Container
     */
    public function register(Container $pimple): Container
    {
        $pimple['db'] = new Database();

        return $pimple;
    }
}