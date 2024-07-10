<?php

namespace App;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use Twig\Extension\DebugExtension;
use App\Extensions\Twig\AssetExtension;
use App\Extensions\Twig\DotenvExtension;
use App\Extensions\Twig\SessionExtension;
use App\Extensions\Twig\UrlExtension;
use App\Contracts\ViewEngineInterface;

class TwigEngine implements ViewEngineInterface
{
    /** @var $twig */
    private $twig;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->twig = new Environment(new FilesystemLoader($this->viewPath()), [
            'cache' => env('APP_CACHE') ? $this->cachePath() : false,
            'debug' => env('APP_DEBUG'),
        ]);

        $this->twig->addGlobal('session', $_SESSION);
        $this->twig->addGlobal('request', $_REQUEST);

        $this->twig->addExtension(new DebugExtension());
        $this->twig->addExtension(new DotenvExtension());
        $this->twig->addExtension(new AssetExtension());
        $this->twig->addExtension(new SessionExtension());
        $this->twig->addExtension(new UrlExtension());
    }

    /**
     * Render template
     * 
     * @param string $template
     * @param array $data
     * @return string
     */
    public function render(string $template, array $data = []): string
    {
        return $this->twig->render($template, $data);
    }

    /**
     * Resolve view path.
     *
     * @return string
     */
    private function viewPath(): string
    {
        return __DIR__ . '/../resources/views';
    }

    /**
     * Resolve cache path.
     *
     * @return string
     */
    private function cachePath(): string
    {
        return __DIR__ . '/../public/cache';
    }
}