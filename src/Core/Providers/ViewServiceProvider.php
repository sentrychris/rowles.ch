<?php

namespace Rowles\Core\Providers;

use Pimple\Container;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use Twig\Extension\DebugExtension;
use Pimple\ServiceProviderInterface;
use Rowles\Core\Extensions\Twig\AssetExtension;
use Rowles\Core\Extensions\Twig\DotenvExtension;

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
    public function register(Container $container)
    {
        $loader = new FilesystemLoader($this->viewPath());
        $container['view'] = new Environment($loader, [
            'cache' => env('APP_CACHE') ?? $this->cachePath(),
            'debug' => env('APP_DEBUG'),
        ]);
        $container['view']->addExtension(new DebugExtension());
        $container['view']->addExtension(new DotenvExtension());
        $container['view']->addExtension(new AssetExtension());

        return $container;
    }

    /**
     * Resolve view path.
     *
     * @return string
     */
    private function viewPath()
    {
        return __DIR__ . '/../../../resources/views';
    }

    /**
     * Resolve cache path.
     *
     * @return string
     */
    private function cachePath()
    {
        return __DIR__ . '/../../../public/cache';
    }
}