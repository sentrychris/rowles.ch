<?php

namespace App\Providers;

use App\Versyx\Service\Container;
use App\Versyx\Service\ServiceProviderInterface;
use App\Versyx\View\TwigEngine;
use App\Versyx\View\ViewEngineInterface;

/**
 * Class ViewServiceProvider
 * 
 * Versyx uses twig by default.
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