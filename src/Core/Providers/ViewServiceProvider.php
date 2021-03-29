<?php

namespace Rowles\Core\Providers;

use Pimple\Container;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use Twig\Extension\DebugExtension;
use Pimple\ServiceProviderInterface;
use Rowles\Core\Extensions\Twig\AssetExtension;
use Rowles\Core\Extensions\Twig\DotenvExtension;
use Rowles\Core\Extensions\Twig\SessionExtension;

/**
 * Class ViewServiceProvider
 */
class ViewServiceProvider implements ServiceProviderInterface
{
    /**
     * Register view service provider.
     *
     * @param Container $pimple
     * @return Container
     */
    public function register(Container $pimple): Container
    {
        $loader = new FilesystemLoader($this->viewPath());
        $pimple['view'] = new Environment($loader, [
            'cache' => env('APP_CACHE') ?? $this->cachePath(),
            'debug' => env('APP_DEBUG'),
        ]);
        $pimple['view']->addGlobal('session', $_SESSION);
        $pimple['view']->addGlobal('request', $_REQUEST);

        $pimple['view']->addExtension(new DebugExtension());
        $pimple['view']->addExtension(new DotenvExtension());
        $pimple['view']->addExtension(new AssetExtension());
        $pimple['view']->addExtension(new SessionExtension());

        return $pimple;
    }

    /**
     * Resolve view path.
     *
     * @return string
     */
    private function viewPath(): string
    {
        return __DIR__ . '/../../../resources/views';
    }

    /**
     * Resolve cache path.
     *
     * @return string
     */
    private function cachePath(): string
    {
        return __DIR__ . '/../../../public/cache';
    }
}