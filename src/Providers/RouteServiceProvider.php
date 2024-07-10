<?php

namespace App\Providers;

use FastRoute\RouteCollector;
use App\Versyx\Service\Container;
use App\Versyx\Service\ServiceProviderInterface;

use function FastRoute\simpleDispatcher;

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
        $container['router'] = simpleDispatcher(function(RouteCollector $rc) {
            $routes = require __DIR__ . '/../../config/routes.php';
            if (! $routes) {
                throw new \RuntimeException('No routes found, please ensure they are correctly configured.');
            }

            foreach($routes as $route) {
                [$method, $path, $handler] = $route;
                $rc->addRoute($method, $path, $handler);
            }
        });

        return $container;
    }
}